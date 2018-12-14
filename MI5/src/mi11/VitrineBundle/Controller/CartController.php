<?php

namespace mi11\VitrineBundle\Controller;


use mi11\VitrineBundle\Entity\Article;
use mi11\VitrineBundle\Entity\Command;
use mi11\VitrineBundle\Entity\CommandDetails;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends Controller
{

    /**
     * @Route("/")
     */
    public function viewSessionAction()
    {
        $session = $this->get("session");
        $cart = $session->get('cart');
        if (!$cart instanceof Command) {
            $cart = new Command();
            $session->set('cart', $cart);
        }

        return $this->render('@mi11Vitrine/Cart/view.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * @Route("/add/{id}")
     */
    public function addAction(Article $article, Request $request)
    {
        $session = $this->get("session");
        $cart = $session->get('cart');
        if (!$cart instanceof Command) {
            $cart = new Command();
            $session->set('cart', $cart);
        }

        //Todo get if exist details
        $details = new CommandDetails();

        $present = false;
        /** @var CommandDetails $detail */
        foreach ($cart->getDetails() as $detail) {
            if ($detail->getArticle()->getId() == $article->getId()) {
                $detail->setQuantity($detail->getQuantity() + 1);
                $present = true;
            }
        }
        if (!$present) {
            $details->setArticle($article);
            $details->setQuantity(1);
            $details->setCommand($cart);
        }

        $session->getFlashBag()->add('success', 'Article ajouté au pannier');

        $session->set('cart', $cart);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction(Article $article)
    {
        $session = $this->get("session");
        $cart = $session->get('cart');
        if (!$cart instanceof Command) {
            $cart = new Command();
        }

        /** @var CommandDetails $detail */
        foreach ($cart->getDetails() as $detail) {
            if ($detail->getArticle()->getId() == $article->getId()) {
                $cart->removeDetail($detail);
            }
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('mi11_vitrine_cart_viewsession');
    }

    /**
     * @Route("/validate")
     * @Security("has_role('ROLE_USER')")
     */
    public function validateAction()
    {
        $session = $this->get("session");
        $cart = $session->get('cart');
        if (!$cart instanceof Command) {
            return $this->redirectToRoute('mi11_vitrine_default_index');
        }

        $cartUtils = $this->get('mi11\VitrineBundle\Services\CartUtils');

        $cart->setClient($this->getUser());

        $cart = $cartUtils->validateCart($cart);

        $session->set('cart', new Command()); //Make empty card in session

        $session = $this->get("session");
        $session->getFlashBag()->add('success', 'Panier validé');

        return $this->redirectToRoute('mi11_vitrine_cart_view',
            [
                'id' => $cart->getId()
            ]);
    }

    /**
     * @Route("/view/commands")
     */
    public function viewListCommandsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commands = $em->getRepository('mi11VitrineBundle:Command')->findBy([

            'client' => $this->getUser()
        ]);

        return $this->render('@mi11Vitrine/Cart/viewCommands.html.twig',[
            'commands' => $commands
        ]);
    }

    /**
     * @Route("/pay/{id}")
     */
    public function payCommandAction(Command $command)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $command->setIsValidated(true);
        $cartUtils = $this->get('mi11\VitrineBundle\Services\CartUtils');

        try {
            $cartUtils->removeStock($command);
            $command->setDate(new \DateTime());
            $session->getFlashBag()->add('success', 'Commande payée');
            $em->flush();

        } catch (\Exception $e) {
            $session->getFlashBag()->add('danger', $e->getMessage());
        }

        return $this->redirectToRoute('mi11_vitrine_cart_viewlistcommands');
    }

    /**
     * @Route("/view/{id}")
     */
    public function viewAction(Command $command)
    {
        return $this->render('@mi11Vitrine/Cart/viewValidation.html.twig', [
            'cart' => $command
        ]);
    }



}
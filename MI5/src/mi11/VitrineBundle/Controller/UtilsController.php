<?php

namespace mi11\VitrineBundle\Controller;


use mi11\VitrineBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UtilsController extends Controller
{

    public function navbarAction()
    {
        $session = $this->get('session');

        $cart = $session->get('cart');
        if (!$cart instanceof Command) {
            $cart = new Command();
            $session->set('cart',$cart);
        }
        return $this->render('modules/navbar.html.twig',[
            'cart' => $cart
        ]);
    }

    public function bestSellerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $details = $em->getRepository('mi11VitrineBundle:CommandDetails')->findBestSeller();

        $articles = [];
        foreach ($details as $detail)
        {
            $articles [] = $em->getRepository('mi11VitrineBundle:Article')->find($detail['article']);
        }

        return $this->render('modules/best_sell.html.twig',[
            'articles' => $articles
        ]);
    }

}
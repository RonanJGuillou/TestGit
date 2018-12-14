<?php

namespace mi11\VitrineBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use mi11\VitrineBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}", defaults={"_locale": "fr"})
 */
class DefaultController extends Controller
{
    /**
     * @Route("/accueil/{name}")
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($name = "visiteur")
    {
        return $this->render('@mi11Vitrine/Default/index.html.twig',[
            'name' => $name
        ]);
    }

    /**
     * @Route("/mentions")
     */
    public function mentionAction()
    {
        return $this->render('@mi11Vitrine/Default/mentions.html.twig');
    }

    /**
     * @Route("/catalogue")
     */
    public function catalogueAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('mi11VitrineBundle:Category')->findAll();

        return $this->render('@mi11Vitrine/Default/catalogue.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/catalogue/{id}")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryDetailsAction(Category $category)
    {
        return $this->render('@mi11Vitrine/Default/categoryDetails.html.twig',[
            'category' => $category
        ]);
    }
}

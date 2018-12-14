<?php

namespace mi11\VitrineBundle\Controller;

use mi11\VitrineBundle\Entity\Command;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Command controller.
 *
 * @Route("/command")
 * @Security("has_role('ROLE_ADMIN')")
 */
class CommandController extends Controller
{
    /**
     * Lists all command entities.
     *
     * @Route("/", name="command_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commands = $em->getRepository('mi11VitrineBundle:Command')->findAll();

        return $this->render('command/index.html.twig', array(
            'commands' => $commands,
        ));
    }

    /**
     * Creates a new command entity.
     *
     * @Route("/new", name="command_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $command = new Command();
        $form = $this->createForm('mi11\VitrineBundle\Form\CommandType', $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($command);
            $em->flush();

            return $this->redirectToRoute('command_show', array('id' => $command->getId()));
        }

        return $this->render('command/new.html.twig', array(
            'command' => $command,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a command entity.
     *
     * @Route("/{id}", name="command_show")
     * @Method("GET")
     */
    public function showAction(Command $command)
    {
        $deleteForm = $this->createDeleteForm($command);

        return $this->render('command/show.html.twig', array(
            'command' => $command,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing command entity.
     *
     * @Route("/{id}/edit", name="command_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Command $command)
    {
        $deleteForm = $this->createDeleteForm($command);
        $editForm = $this->createForm('mi11\VitrineBundle\Form\CommandType', $command);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('command_edit', array('id' => $command->getId()));
        }

        return $this->render('command/edit.html.twig', array(
            'command' => $command,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a command entity.
     *
     * @Route("/{id}", name="command_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Command $command)
    {
        $form = $this->createDeleteForm($command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($command);
            $em->flush();
        }

        return $this->redirectToRoute('command_index');
    }

    /**
     * Creates a form to delete a command entity.
     *
     * @param Command $command The command entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Command $command)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('command_delete', array('id' => $command->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

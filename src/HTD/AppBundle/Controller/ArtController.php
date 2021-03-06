<?php

namespace HTD\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HTD\AppBundle\Entity\Art;
use HTD\AppBundle\Form\ArtType;

/**
 * Art controller.
 *
 * @Route("/art")
 */
class ArtController extends Controller
{

    /**
     * Lists all Art entities.
     *
     * @Route("/", name="art")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HTDAppBundle:Art')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Art entity.
     *
     * @Route("/", name="art_create")
     * @Method("POST")
     * @Template("HTDAppBundle:Art:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Art();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('art_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Art entity.
     *
     * @param Art $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Art $entity)
    {
        $form = $this->createForm(new ArtType(), $entity, array(
            'action' => $this->generateUrl('art_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Art entity.
     *
     * @Route("/new", name="art_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Art();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Art entity.
     *
     * @Route("/{id}", name="art_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HTDAppBundle:Art')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Art entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Art entity.
     *
     * @Route("/{id}/edit", name="art_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HTDAppBundle:Art')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Art entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Art entity.
    *
    * @param Art $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Art $entity)
    {
        $form = $this->createForm(new ArtType(), $entity, array(
            'action' => $this->generateUrl('art_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Art entity.
     *
     * @Route("/{id}", name="art_update")
     * @Method("PUT")
     * @Template("HTDAppBundle:Art:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HTDAppBundle:Art')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Art entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('art_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Art entity.
     *
     * @Route("/{id}", name="art_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HTDAppBundle:Art')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Art entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('art'));
    }

    /**
     * Creates a form to delete a Art entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('art_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

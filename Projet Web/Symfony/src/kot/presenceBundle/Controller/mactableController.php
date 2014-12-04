<?php

namespace kot\presenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use kot\presenceBundle\Entity\mactable;
use kot\presenceBundle\Form\mactableType;

/**
 * mactable controller.
 *
 * @Route("/mactable")
 */
class mactableController extends Controller
{

    /**
     * Lists all mactable entities.
     *
     * @Route("/", name="mactable")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('kotpresenceBundle:mactable')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new mactable entity.
     *
     * @Route("/", name="mactable_create")
     * @Method("POST")
     * @Template("kotpresenceBundle:mactable:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new mactable();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mactable_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a mactable entity.
     *
     * @param mactable $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(mactable $entity)
    {
        $form = $this->createForm(new mactableType(), $entity, array(
            'action' => $this->generateUrl('mactable_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new mactable entity.
     *
     * @Route("/new", name="mactable_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new mactable();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a mactable entity.
     *
     * @Route("/{id}", name="mactable_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:mactable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find mactable entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing mactable entity.
     *
     * @Route("/{id}/edit", name="mactable_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:mactable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find mactable entity.');
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
    * Creates a form to edit a mactable entity.
    *
    * @param mactable $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(mactable $entity)
    {
        $form = $this->createForm(new mactableType(), $entity, array(
            'action' => $this->generateUrl('mactable_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing mactable entity.
     *
     * @Route("/{id}", name="mactable_update")
     * @Method("PUT")
     * @Template("kotpresenceBundle:mactable:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:mactable')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find mactable entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mactable_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a mactable entity.
     *
     * @Route("/{id}", name="mactable_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('kotpresenceBundle:mactable')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find mactable entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mactable'));
    }

    /**
     * Creates a form to delete a mactable entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mactable_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

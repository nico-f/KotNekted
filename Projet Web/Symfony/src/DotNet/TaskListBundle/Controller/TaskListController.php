<?php

namespace DotNet\TaskListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DotNet\TaskListBundle\Entity\TaskList;
use DotNet\TaskListBundle\Form\TaskListType;

/**
 * TaskList controller.
 *
 * @Route("/tasklist")
 */
class TaskListController extends Controller
{

    /**
     * Lists all TaskList entities.
     *
     * @Route("/", name="list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DotNetTaskListBundle:TaskList')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TaskList entity.
     *
     * @Route("/", name="list_create")
     * @Method("POST")
     * @Template("DotNetTaskListBundle:TaskList:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TaskList();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

          return $this->redirect($this->generateUrl('list'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TaskList entity.
     *
     * @param TaskList $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TaskList $entity)
    {
        $form = $this->createForm(new TaskListType(), $entity, array(
            'action' => $this->generateUrl('list_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TaskList entity.
     *
     * @Route("/new", name="list_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TaskList();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TaskList entity.
     *
     * @Route("/{id}", name="list_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DotNetTaskListBundle:TaskList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TaskList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TaskList entity.
     *
     * @Route("/{id}/edit", name="list_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DotNetTaskListBundle:TaskList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TaskList entity.');
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
    * Creates a form to edit a TaskList entity.
    *
    * @param TaskList $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TaskList $entity)
    {
        $form = $this->createForm(new TaskListType(), $entity, array(
            'action' => $this->generateUrl('list_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TaskList entity.
     *
     * @Route("/{id}", name="list_update")
     * @Method("PUT")
     * @Template("DotNetTaskListBundle:TaskList:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DotNetTaskListBundle:TaskList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TaskList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('list_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TaskList entity.
     *
     * @Route("/{id}", name="list_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DotNetTaskListBundle:TaskList')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TaskList entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('list'));
    }

    /**
     * Creates a form to delete a TaskList entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('list_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

<?php

namespace kot\presenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use kot\presenceBundle\Entity\expenses;
use kot\presenceBundle\Form\expensesType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

/**
 * expenses controller.
 *
 * @Route("/expenses")
 */
class expensesController extends Controller
{

    /**
     * Lists all expenses entities.
     *
     * @Route("/", name="expenses")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('kotpresenceBundle:expenses')->findAll();

        return array(
            'entities' => $entities,
            'usernumber' => $this->getUserNumberAndTotalExpenses()[0],
            'usersexpenses' => $this->getExpensesPerUser(),
            'expenses' => $this->getExpensesHistory(),
            'userid' => $this->getUser()
        );
    }
    /**
     * Creates a new expenses entity.
     *
     * @Route("/", name="expenses_create")
     * @Method("POST")
     * @Template("kotpresenceBundle:expenses:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new expenses();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $loggedUser = $this->get('security.context')->getToken()->getUser();
        $entity ->setUsrid($loggedUser)
                ->setDate(new \DateTime())
        ;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('expenses_show', array('id' => $entity->getId() )));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'user' => $loggedUser,
        );
    }

    /**
     * Creates a form to create a expenses entity.
     *
     * @param expenses $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(expenses $entity)
    {
        $form = $this->createForm(new expensesType(), $entity, array(
            'action' => $this->generateUrl('expenses_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Ajouter'));
        return $form;
    }

    /**
     * Displays a form to create a new expenses entity.
     *
     * @Route("/new", name="expenses_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new expenses();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a expenses entity.
     *
     * @Route("/{id}", name="expenses_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:expenses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find expenses entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing expenses entity.
     *
     * @Route("/{id}/edit", name="expenses_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:expenses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find expenses entity.');
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
    * Creates a form to edit a expenses entity.
    *
    * @param expenses $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(expenses $entity)
    {
        $form = $this->createForm(new expensesType(), $entity, array(
            'action' => $this->generateUrl('expenses_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing expenses entity.
     *
     * @Route("/{id}", name="expenses_update")
     * @Method("PUT")
     * @Template("kotpresenceBundle:expenses:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:expenses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find expenses entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('expenses_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a expenses entity.
     *
     * @Route("/{id}", name="expenses_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('kotpresenceBundle:expenses')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find expenses entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('expenses'));
    }

    /**
     * Creates a form to delete a expenses entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expenses_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }

    public function getUserNumberAndTotalExpenses()
    {
      $query = $this->getDoctrine()->getManager()->createQuery("
          select count(u.id), (select sum(e.amount) from kotpresenceBundle:expenses e)
          from kotpresenceBundle:User u
        ");
      $result = $query->getResult();

      return $result;

    }

    function getExpensesPerUser()
    {
      $query = $this->getDoctrine()->getManager()->createQuery("
          select (select u.username from kotpresenceBundle:User u where e.usrid = u.id), sum(e.amount)
          from kotpresenceBundle:expenses e
          group by e.usrid
        ");
      return $query->getResult();
    }

    public function getExpensesHistory()
    {
      $expenseslist =  $this->getDoctrine()->getManager()->createQuery("
          select
            (select u.username
            from kotpresenceBundle:User u
            where u.id = e.usrid
          ), e.description,  e.amount,e.date, e.id exid
          from kotpresenceBundle:expenses e

        ")->getResult();

      return $expenseslist;
    }
}

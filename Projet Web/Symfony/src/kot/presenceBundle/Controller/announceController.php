<?php

namespace kot\presenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use kot\presenceBundle\Entity\announce;
use kot\presenceBundle\Form\announceType;

/**
 * announce controller.
 *
 * @Route("/announce")
 */
class announceController extends Controller
{

    /**
     * Lists all announce entities.
     *
     * @Route("/", name="announce")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('kotpresenceBundle:announce')->findBy(array(), array('id' => 'DESC'));

        return array(
            'entities' => $entities,
            'userid' => $this->getUser()
        );
    }


  /**
   * Lists all announce entities.
   *
   * @Route("/", name="new_announce")
   * @Method("GET")
   * @Template()
   */
    public function new_announceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $newannounce = $this->getUser()->getidLastMsgRead();

        $entities = $em->createQuery("
          select a.id, a.message, IDENTITY(a.id_author) idAuthor, a.creationDate, u.username
          from kotpresenceBundle:announce a
          left join kotpresenceBundle:User u where a.id_author = u.id
          where $newannounce < a.id
          order by a.id desc
        ")->getResult();

      if(!empty($entities))
      {
        $usertoupdate = $em->getRepository('kotpresenceBundle:User')->find($this->getUser()->getid());
        $usertoupdate->setidLastMsgRead($entities[0]['id']);
        $em->flush();
      }

        return array(
          'entities' => $entities,
          'userid' => $this->getUser()
        );
    }


    /**
     * Creates a new announce entity.
     *
     * @Route("/", name="announce_create")
     * @Method("POST")
     * @Template("kotpresenceBundle:announce:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new announce();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $entity   ->setIdAuthor($this->get('security.context')->getToken()->getUser())
                  ->setCreationDate(new \DateTime());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('announce_show', array('id' => $entity->getId())));
        }


        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a announce entity.
     *
     * @param announce $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(announce $entity)
    {
        $form = $this->createForm(new announceType(), $entity, array(
            'action' => $this->generateUrl('announce_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new announce entity.
     *
     * @Route("/new", name="announce_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new announce();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a announce entity.
     *
     * @Route("/{id}", name="announce_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:announce')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find announce entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing announce entity.
     *
     * @Route("/{id}/edit", name="announce_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:announce')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find announce entity.');
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
    * Creates a form to edit a announce entity.
    *
    * @param announce $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(announce $entity)
    {
        $form = $this->createForm(new announceType(), $entity, array(
            'action' => $this->generateUrl('announce_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing announce entity.
     *
     * @Route("/{id}", name="announce_update")
     * @Method("PUT")
     * @Template("kotpresenceBundle:announce:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kotpresenceBundle:announce')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find announce entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('announce_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a announce entity.
     *
     * @Route("/{id}", name="announce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('kotpresenceBundle:announce')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find announce entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('announce'));
    }

    /**
     * Creates a form to delete a announce entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('announce_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}

<?php

  namespace kot\presenceBundle\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\Controller;
  use Symfony\Component\HttpFoundation\Response;

  class depensesController extends Controller
  {
    public function indexAction()
    {
      return $this->render('kotpresenceBundle:pages:depenses.html.twig', array('expenses' => $this->getExpensesHistory(), 'usernumber' => $this->getUserNumberAndTotalExpenses()[0], 'usersexpenses' => $this->getExpensesPerUser()));
    }

    public function getExpensesHistory()
    {
      $expenseslist =  $this->getDoctrine()->getManager()->createQuery("
        select
          (select u.username
          from kotpresenceBundle:User u
          where u.id = e.usrid
        ), e.description,  e.amount,e.date
        from kotpresenceBundle:expenses e

      ")->getResult();

      return $expenseslist;
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


  }
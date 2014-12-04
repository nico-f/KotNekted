<?php

  namespace kot\presenceBundle\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\Controller;
  use Symfony\Component\HttpFoundation\Response;

  class photoController extends Controller
  {
    public function indexAction()
    {
      return $this->render('kotpresenceBundle:pages:photo.html.twig');
    }
  }
?>
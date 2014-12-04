<?php

namespace kot\presenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('kotpresenceBundle:Default:index.html.twig', array('name' => $name));
    }
}

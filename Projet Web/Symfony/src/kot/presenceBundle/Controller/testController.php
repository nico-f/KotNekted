<?php

namespace kot\presenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction()
    {
       return $this->render('kotpresenceBundle:Test:index.html.twig');
    }
}

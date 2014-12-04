<?php


  namespace kot\presenceBundle\Controller;

  use kot\presenceBundle\Entity\mactable;
  use Symfony\Bundle\FrameworkBundle\Controller\Controller;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;

  class linkDeviceController extends Controller
  {
    function indexAction()
    {
      $dt = $this->getDoctrine()->getManager()->createQuery("
      select d.slug
      from kotpresenceBundle:deviceType d
      ")->getResult();



      return $this->render('kotpresenceBundle:pages:linkdevice.html.twig', array('devicetype' => $dt));
    }

    function newlinkAction(Request $request)
    {

      $xml = simplexml_load_file('mac/ip.xml');
      for($i = 0 ; $i < count($xml) ; $i++)
      {
        if(getHostByName(getHostName()) == get_object_vars(get_object_vars($xml)['address'][$i])['@attributes']['addr'] )
        {
          $linkedmac = get_object_vars(get_object_vars($xml)['address'][$i+1])['@attributes']['addr'];
        }
      }
      $entity = new mactable();
      $entity ->setUserid($this->getUser())
            ->setMacad($linkedmac);

      $form = $this->createFormBuilder($entity)
            ->add('devicetypeid', 'entity', array('choices' => $this->getDeviceType(), 'label' => ' ', 'expanded' => true, 'class' => 'kotpresenceBundle:deviceType'))
            ->add('Valider', 'submit')
            ->getForm();


      $form->handleRequest($request);

      if($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
      }

      return $this->render('@kotpresence/pages/linkdevice.html.twig', array('form' => $form->createView()));
    }

    function getDeviceType()
    {
      $dt = $this->getDoctrine()->getManager()->getRepository('kotpresenceBundle:deviceType')->findAll();
      return $dt;
    }
  }

?>
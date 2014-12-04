<?php

  namespace kot\presenceBundle\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\Controller;
  use Symfony\Component\HttpFoundation\Response;


  class imageController extends Controller {
    function indexAction()
    {
      $netinfos = $this->getNetworkInfosAction();
      echo "<br/>";
      echo "<br/>";
      echo "<br/>";
      echo "<br/>";
      echo('<pre>');
      print_r(gethostbyname($_SERVER['REMOTE_ADDR']));
      print_r(shell_exec('arp -a'));
      echo('</pre>');

      return $this->render('kotpresenceBundle:pages:listepresent.html.twig', $netinfos);
    }

    function getNetworkInfosAction()
    {
      $xml = simplexml_load_file('mac/ip.xml');
      $contents ='';
      $length = 0;
      $linkedmac = '';
      for($i = 0 ; $i < count($xml) ; $i++)
      {
        if(getHostByName(getHostName()) == get_object_vars(get_object_vars($xml)['address'][$i])['@attributes']['addr'] )
        {
          $linkedmac = get_object_vars(get_object_vars($xml)['address'][$i+1])['@attributes']['addr'];
        }

        if(get_object_vars(get_object_vars($xml)['address'][$i])['@attributes']['addrtype'] =='mac')
        {
          if(!empty($contents))
          {
            $contents .=',';
          }
          $contents .= '\''.get_object_vars(get_object_vars($xml)['address'][$i])['@attributes']['addr'].'\'';
          $length++;
        }
      }
      $em = $this->getDoctrine()->getManager();

      $query = $em->createQuery("
      select m.macad, u.id, d.id deviceid, u.username, d.slug, m.macad
      from kotpresenceBundle:mactable m
      left join kotpresenceBundle:User u where m.userid = u.id
      left join kotpresenceBundle:devicetype d where m.devicetypeid = d.id
      where m.macad in ($contents)
      order by u.id, d.id desc
      ");
      $users = $query->getResult();

      $session = $this->getRequest()->getSession();
      $session ->set('ip',getHostByName(getHostName()));
      $session ->set('mac',$linkedmac);

      return  array( 'length'=>$length, 'users' =>$users, 'content'=> $contents );
    }
  }

?>
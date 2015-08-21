<?php

namespace LAuth\MagicBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LAuthMagicBoxBundle:Default:index.html.twig', array('name' => $name));
    }
}

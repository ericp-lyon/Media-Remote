<?php

namespace MediaRemoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/default", name="default")
     */
    public function indexAction()
    {
        return $this->render('@MediaRemote/Default/index.html.twig');
    }
}

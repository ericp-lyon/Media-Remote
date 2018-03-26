<?php

namespace MediaRemoteBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MediaRemoteBundle\Entity\MediaRemote;
use MediaRemoteBundle\Entity\Remote;
use MediaRemoteBundle\Form\RemoteType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Config\Definition\Exception\Exception;
use MediaRemoteBundle\Entity\Media;

class MediaRemoteController extends Controller
{
    /**
     *@Route("/remote/{remote_name}/{media_name}/toogle",
     *name="toogle",
     *requirements={
     *"remote_name"="^[A-Z]{1}[a-z]{2,15}$",
     *"media_name"="^[A-Z]{1}[A-Za-z]{2,15}$",
     *},
     *methods="GET"
     * )
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function toogleAction(Request $request)
    {
        $this->get("session")
        ->getFlashBag()
        ->add("toogle", true);
     
        $this->get("cache.app")
        ->deleteItem(md5($request->get("remote_name")));
        
        $mediaRemote =$this
        ->getDoctrine()
        ->getManager()
        ->getRepository(MediaRemote::class)
        ->findByRemoteNameAndMediaName(
             $request->get("remote_name"),
             $request->get("media_name")
        );
        $mediaRemote->setMediaRemoteActive(
            !$mediaRemote->getMediaRemoteActive());
        $this->getDoctrine()
             ->getManager()
             ->flush();
             return $this->redirectToRoute("remote_get",[
                 "remote_name" => $mediaRemote->getRemote()->getRemoteName()
        
                 ]);
      
    }

}

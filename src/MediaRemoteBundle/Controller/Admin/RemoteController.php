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




class RemoteController extends Controller
{
    
    /**
     * 
     * @param string $name
     * @throws NotFoundHttpException
     * @return array
     */
    private function getMediaRemote(string $name):array
    {
              
        if(!($mediaRemote = $this->getDoctrine()
                            ->getManager()
                            ->getRepository(MediaRemote::class)
                            ->findByRemoteName($name)))
        {
            throw new NotFoundHttpException("Remote not found");
        }
        
        return $mediaRemote;
    }
    /**
     * @Route("/remote", name="remote")
     *@Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        
         
        return  $this->redirectToRoute("remote_get",[
            "remote_name" => $this->getDoctrine()
                            ->getManager()
                            ->getRepository(MediaRemote::class)
                            -> findDefaultRemoteName()
        ]);
 
    }
    
    /**
     * @Route("/remote/{remote_name}",
     *        name="remote_get",
     *        requirements={"remote_name"="^[A-Za-z]{3,32}$"},
     *        methods="GET"
     * )
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function getAction(Request $request)
    {
        $etag=md5($request->getUri());
    
        if (!$this->get("session")->getFlashBag()->get("toogle")
            && current($request->getETags()) === '"' . $etag . '"'){
            
          $response = new Response();
          $response->setNotModified();// permet de faire un 304 et modifie egalement la reponse
          return $response;
    
        }
        $key = md5($request->get("remote_name"));// permet de normaliser le format de la clé
        $cache = $this->get('cache.app');
        $item = $cache->getItem($key);
        
        // vérifie si item est lisible et n'a pas expiré
        if (!$item->isHit()) {
            dump("pas de cache");
            //on recherche la donnée dans le sgbdr
            $mediaRemote = $this->getMediaRemote($request->get("remote_name"));
            // on met la donnée dans le fichier
            $item->set($mediaRemote);
            //on sauvegarde le fichier
            $cache->save($item);
            //sinon on recupère la donnée ddepuis l'item
        } else {
            dump("cache present");
            $mediaRemote = $item->get();
            // reveiller les proxies morts puis réaffectation de la nouvelle donnée
            foreach ($mediaRemote as $value){
                $value ->setMedia(
                    $this->getDoctrine()->getManager()->merge($value->getMedia())
                    );
                
            }
        }
     
        
       
 
        //obtenir la liste des media pour le remote
        //$mediaRemote=  $this->getMediaRemote($request->get("remote_name"));
       
        //construction du formulaire coté back
        //creation d un formaualaire du service form.factory
        $form= $this->get("form.factory")
        ->create(RemoteType::class, // dans la classe précédente
            $mediaRemote[0]->getRemote());//on passe l'objet complet
        
       
        //envoi à la vue et ses arguments
        $response = $this->render('@MediaRemote/Remote/index.html.twig', array(
            "mediaRemote" => $mediaRemote,
            "form"=>$form->createView()
        ));
        $response ->setEtag($etag);
        return $response;
    }
    
    /**
     * @Route("/remote/{remote_name}",
     *        name="remote_post",
     *        requirements={"remote_name"="^[A-Za-z]{3,32}$"},
     *        methods="POST"
     * )
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function postAction(Request $request)
    {
        $mediaRemote =  $this->getMediaRemote($request->get("remote_name"));
        $form = $this->get("form.factory")
                ->create(RemoteType::class, $mediaRemote[0]->getRemote());
                $form ->handleRequest($request);
        
         if($form ->isSubmitted() && $form -> isValid()){
                     
           //  dump("je veux traiter l'info");
             try {
                 $this->getDoctrine()
                 ->getManager()
                 ->flush();
                 $this->get("cache.app")
                 ->deleteItem(md5($request->get("remote_name")));
                 $response= $this->redirectToRoute("remote_get",[
                     "remote_name" => $mediaRemote[0]->getRemote()->getRemoteName()
                 ]);
                 
                
                 $response ->setEtag(null); // nettoyage du cache pour Etag
                 return $response;
                 
                 
             } catch (\Throwable $e) {
                
                 $form->addError(new FormError("name.exists"));

             }
          }
         return $this->render('@MediaRemote/Remote/index.html.twig', array(
             "mediaRemote" => $mediaRemote,// envoi de la valeur à la vue
             "form"=>$form->createView()//creation du formulaire à la vue
         ));
      
      
    }
    
//     /**
//      * @Route("/remote/{remote_name}/{media_name}/switch",
//      *        name="toogle",
//      *        methods="GET"
//      * )
//      * @Security("has_role('ROLE_ADMIN')")
//      */
//     public function getSwitchValueMediaAction(Request $request)
//     {      
//         $remote =$this->getDoctrine()
//                     ->getManager()
//                     ->getRepository(Remote::class)
//                     ->findOneByRemoteName($request->get("remote_name"));
        
//         $media =$this->getDoctrine()
//                     ->getManager()
//                     ->getRepository(Media::class)
//                     ->findOneByMediaName($request->get("media_name"));
        
//         $mediaRemote =$this->getDoctrine()
//                     ->getManager()
//                     ->getRepository(MediaRemote::class)
//                     ->findOneBy([
//                         "remote"=>$remote,
//                         "media"=>$media
//                     ]);
                    
//          $mediaRemote->setMediaRemoteActive(!$mediaRemote->getMediaRemoteActive());
                    
//          $this->getDoctrine()
//             ->getManager()
//             ->flush();
                    
//          return  $this->redirectToRoute("remote_get",[
//                           "remote_name" =>  $mediaRemote->getRemote()
//                                                 ->getRemoteName()
//                            ]);
   
//     }
    
    
    
}

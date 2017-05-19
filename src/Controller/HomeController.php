<?php

namespace projet3\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use projet3\Domain\Comment;
use projet3\Form\Type\CommentType;
use projet3\Form\Type\SubcommentType;
use projet3\Form\Type\BadType;



class HomeController {

     /**
    page accueil qui affiche les billets
     */
    public function indexAction(Application $app) {
        $billets = $app['dao.billets']->findAll();
        return $app['twig']->render('index.html.twig', array('billets' => $billets));
    }
    
     /**
    fonction qui afiche les details des billets 
    et les commentaires
     */
    public function billetsAction($id, Request $request, Application $app) {
        $billets = $app['dao.billets']->find($id);
        $comment = new Comment();
        $comment->setBillets($billets);
      
      
        
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        $commentFormView = $commentForm->createView();
        
        
           if ($commentForm->isSubmitted() && $commentForm->isValid()) 
               {
                 $app['dao.comment']->save($comment);
                 
              
               } 
              $comments = $app['dao.comment']->findAllByBillets($id);
        
        $subcomment = new Comment();
        
        $subcommentForm = $app['form.factory']->create(CommentType::class, $subcomment);
        $subcommentForm->handleRequest($request);
        $subcommentFormView = $subcommentForm->createView(); 
        
          return $app['twig']->render('billets.html.twig', array(
                  'billets' => $billets,
                  'comments' => $comments,
                  'commentForm' => $commentFormView,
                  'subcommentForm' => $subcommentFormView));
    }
     
    // fonction qui recupere le signalement 
    
 public function badAction($id, Request $request, Application $app) {
        
                 $app['dao.comment']->bad("OUI", $id );
                 $comment=$app['dao.comment']-> find ($id );
                 $billet =$comment->getBillets();
                 return $this->billetsAction($billet->getId(),$request,$app);
     
                
 }
     // fonction qui permet de ce connecter à l'admin  
    public function loginAction(Request $request, Application $app) {
        
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
           'last_username' => $app['session']->get('_security.last_username'),
            
        ));
    }
}
    
   
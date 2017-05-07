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
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $billets = $app['dao.billets']->findAll();
        return $app['twig']->render('index.html.twig', array('billets' => $billets));
    }
    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
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
     
    // fonction du controleur qui recupere le signalement 
    
 public function badAction($id, Request $request, Application $app) {
        $bad = $app['dao.comment']->find($id);
        $comment = new Comment();
        $comment->setBad($bad);
      
      
        
        $badForm = $app['form.factory']->create(BadType::class, $bad);
        $badForm->handleRequest($request);
        $badFormView = $badForm->createView();
        
        
           if ($badForm->isSubmitted() && $badForm->isValid()) 
               {
                 $app['dao.comment']->bad($bad);
                 
              
               } 
         return $app['twig']->render('billets.html.twig', array(
                 'badForm' => $badFormView));
 }
     
    public function loginAction(Request $request, Application $app) {
        
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
           'last_username' => $app['session']->get('_security.last_username'),
            
        ));
    }
}
    
   
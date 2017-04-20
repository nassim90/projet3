<?php

namespace blog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use blog\Domain\Comment;
use blog\Form\Type\CommentType;
use blog\Form\Type\SubcommentType;



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
     
 /*public function parentAction($id, Request $request, Application $app) {
        $comment = $app['dao.comment']->find($parentId);
        $subcomment = new Comment();
        $subcomment->setParent($parent);
      
        
        $subcommentForm = $app['form.factory']->create(SubcommentType::class, $subcomment);
        $subcommentForm->handleRequest($request);
        $subcommentFormView = $subcommentForm->createView();
        
        
           if ($subcommentForm->isSubmitted() && $subcommentForm->isValid()) 
               {
                 $app['dao.comment']->save($subcomment);
                 $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
              
               } 
              $subcomments = $app['dao.comment']->findAllByParentId($parentId);
                  
          return $app['twig']->render('billets.html.twig', array(
                  
                  'comments' => $comments,
                  'subcomments'=>$subcomments,
                  'subcommentForm' => $subcommentFormView));
    }*/
    
    
    
    public function loginAction(Request $request, Application $app) {
        
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
           'last_username' => $app['session']->get('_security.last_username'),
            
        ));
    }
}
    
   
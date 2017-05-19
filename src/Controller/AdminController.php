<?php

namespace projet3\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use projet3\Domain\Billets;
use projet3\Domain\User;
use projet3\Form\Type\BilletsType;
use projet3\Form\Type\CommentType;
use projet3\Form\Type\UserType;

class AdminController {

    /**
    page accueil de l'admin
     */
    public function indexAction(Application $app) {
        $billets = $app['dao.billets']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'billets' => $billets,
            'comments' => $comments,
            'users' => $users));
    }

    /**
    fonction qui rajoute un billet
     */
    public function addBilletsAction(Request $request, Application $app) {
        $billets = new Billets();
        $billetsForm = $app['form.factory']->create(BilletsType::class, $billets);
        $billetsForm->handleRequest($request);
        if ($billetsForm->isSubmitted() && $billetsForm->isValid()) {
            $app['dao.billets']->save($billets);
            $app['session']->getFlashBag()->add('bravo', 'Le billet a bien été créer.');
        }
        return $app['twig']->render('billets_form.html.twig', array(
            'title' => 'New billets',
            'billetsForm' => $billetsForm->createView()));
    }

    /**
    fonction qui modifie un billet
     */
    public function editBilletsAction($id, Request $request, Application $app) {
        $billets = $app['dao.billets']->find($id);
        $billetsForm = $app['form.factory']->create(BilletsType::class, $billets);
        $billetsForm->handleRequest($request);
        if ($billetsForm->isSubmitted() && $billetsForm->isValid()) {
            $app['dao.billets']->save($billets);
            $app['session']->getFlashBag()->add('bravo', 'Le billet a bien été modifier.');
        }
        return $app['twig']->render('billets_form.html.twig', array(
            'title' => 'Edit Billets',
            'billetsForm' => $billetsForm->createView()));
    }

    /**
    fonction qui supprime un billet
     */
    public function deleteBilletsAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByBillets($id);
        // Delete the article
        $app['dao.billets']->delete($id);
        $app['session']->getFlashBag()->add('bravo', 'Le billet a bien été supprimer.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     fonction qui modifie le commentaire 
     */
    public function editCommentAction($id, Request $request, Application $app) {
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('bravo', 'Le commentaire a bien été modifier.');
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Rajout commentaire',
            'commentForm' => $commentForm->createView()));
    }

    /**
     fonction qui supprime le commentaire 
     */
    public function deleteCommentAction($id, Application $app) {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('bravo', 'Le commentaire a bien été suprimmer.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

     /**
    fonction qui rajoute un utilisateur
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('bravo', 'L\'utilisateur a bien été créer.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));
    }

    /**
    fonction qui modifie un billet
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('bravo',  'L\'utilisateur a bien été modifier.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));
    }

    /**
    fonction qui supprime un billet
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('bravo', 'L\'utilisateur a bien été suprimmer.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}
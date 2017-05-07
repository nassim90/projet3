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
     * Admin home page controller.
     *
     * @param Application $app Silex application
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

    
    public function addBilletsAction(Request $request, Application $app) {
        $billets = new Billets();
        $billetsForm = $app['form.factory']->create(BilletsType::class, $billets);
        $billetsForm->handleRequest($request);
        if ($billetsForm->isSubmitted() && $billetsForm->isValid()) {
            $app['dao.billets']->save($billets);
            $app['session']->getFlashBag()->add('success', 'The article was successfully created.');
        }
        return $app['twig']->render('billets_form.html.twig', array(
            'title' => 'New billets',
            'billetsForm' => $billetsForm->createView()));
    }

    
    public function editBilletsAction($id, Request $request, Application $app) {
        $billets = $app['dao.billets']->find($id);
        $billetsForm = $app['form.factory']->create(BilletsType::class, $billets);
        $billetsForm->handleRequest($request);
        if ($billetsForm->isSubmitted() && $billetsForm->isValid()) {
            $app['dao.billets']->save($billets);
            $app['session']->getFlashBag()->add('success', 'The article was successfully updated.');
        }
        return $app['twig']->render('billets_form.html.twig', array(
            'title' => 'Edit Billets',
            'billetsForm' => $billetsForm->createView()));
    }

   
    public function deleteBilletsAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByBillets($id);
        // Delete the article
        $app['dao.billets']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The article was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    
    public function editCommentAction($id, Request $request, Application $app) {
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'The comment was successfully updated.');
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The comment was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
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
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
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
            $app['session']->getFlashBag()->add('success', 'The user was successfully updated.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was successfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}
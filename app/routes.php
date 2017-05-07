<?php

// Home page
$app->get('/', "projet3\Controller\HomeController::indexAction")
->bind('home');

// Detailed info about an article
$app->match('/billets/{id}', "projet3\Controller\HomeController::billetsAction")
->bind('billets');

$app->match('/billets/{id}', "projet3\Controller\HomeController::badAction")
->bind('billets');


// Login form
$app->get('/login', "projet3\Controller\HomeController::loginAction")
->bind('login');

// Admin zone
$app->get('/admin', "projet3\Controller\AdminController::indexAction")
->bind('admin');



// Add a new billet
$app->match('/admin/billets/add', "projet3\Controller\AdminController::addBilletsAction")
->bind('admin_billets_add');

// Edit an existing billet
$app->match('/admin/billets/{id}/edit', "projet3\Controller\AdminController::editBilletsAction")
->bind('admin_billets_edit');

// Remove an billet
$app->get('/admin/billets/{id}/delete', "projet3\Controller\AdminController::deleteBilletsAction")
->bind('admin_billets_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "projet3\Controller\AdminController::editCommentAction")
->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "projet3\Controller\AdminController::deleteCommentAction")
->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', "projet3\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "projet3\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "projet3\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');


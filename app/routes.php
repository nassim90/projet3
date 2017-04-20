<?php

// Home page
$app->get('/', "blog\Controller\HomeController::indexAction")
->bind('home');

// Detailed info about an article
$app->match('/billets/{id}', "blog\Controller\HomeController::billetsAction")
->bind('billets');

/*$app->match('/billets/{id}', "blog\Controller\HomeController::parentAction")
->bind('billets');*/

// Login form
$app->get('/login', "blog\Controller\HomeController::loginAction")
->bind('login');

// Admin zone
$app->get('/admin', "blog\Controller\AdminController::indexAction")
->bind('admin');



// Add a new article
$app->match('/admin/billets/add', "blog\Controller\AdminController::addBilletsAction")
->bind('admin_billets_add');

// Edit an existing article
$app->match('/admin/billets/{id}/edit', "blog\Controller\AdminController::editBilletsAction")
->bind('admin_billets_edit');

// Remove an article
$app->get('/admin/billets/{id}/delete', "blog\Controller\AdminController::deleteBilletsAction")
->bind('admin_billets_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "blog\Controller\AdminController::editCommentAction")
->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "blog\Controller\AdminController::deleteCommentAction")
->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', "MicroCMS\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "MicroCMS\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "MicroCMS\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');


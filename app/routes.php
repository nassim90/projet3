<?php

// Home page
$app->get('/', function () use ($app) {
    $billets = $app['dao.billets']->findAll();
    return $app['twig']->render('index.html.twig', array('billets' => $billets));
})->bind('home');

// Article details with comments
$app->get('/billets/{id}', function ($id) use ($app) {
    $billets = $app['dao.billets']->find($id);
    $commentaires = $app['dao.commentaire']->findAllByBillets($id);
    return $app['twig']->render('billets.html.twig', array('billets' => $billets, 'commentaires' => $commentaires));
})->bind('billets');
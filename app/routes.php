<?php

// Home page
$app->get('/', function () use ($app) {
    $billets = $app['dao.billets']->findAll();
    return $app['twig']->render('index.html.twig', array('billets' => $billets));
});
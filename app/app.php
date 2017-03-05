<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));
// Register services.
$app['dao.billets'] = function ($app) {
    return new projet3\DAO\billetsDAO($app['db']);
};

$app['dao.commentaire'] = function ($app) {
    $commentaireDAO = new projet3\DAO\commentaireDAO($app['db']);
    $commentaireDAO->setBilletsDAO($app['dao.billets']);
    return $commentaireDAO;
};

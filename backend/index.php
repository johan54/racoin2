<?php

require_once '../vendor/autoload.php';
use racoin\backend\controller as Controller;

$container = new Slim\Container();

$container['twig'] = function ($container) {
    $loader = new Twig_Loader_Filesystem('../src/racoin/backend/view');
    return new Twig_Environment($loader, array('debug' => true));
};

racoin\app\App::DbConf('../src/racoin/utils/config.ini');

$app = new \Slim\App($container);

//Toutes les actions pour le backend
$app->group('/', function () use ($app) {

    //Affichage de la liste des annonces non validées
    $app->get('unvalidated', function () use ($app) {
            $controller = new Controller\AnnonceController($app);
            return $controller->getUnvalidatedAnnounces();
    });

    //Récupération d'une annonce
    $app->get('annonce/{id}', function ($req, $res, $args) use ($app) {
            $id = $args['id'];
            $controller = new Controller\AnnonceController($app);
            return $controller->getAnnounceById($id);
    });
});

//valider une annonce
$app->get('/annonce/{id}/validate', function ($req, $res, $args) use ($app) {

    $id = $args['id'];
    $controller = new Controller\AnnonceController($app);
    return $controller->validateAnnounceById($id);
});

$app->run();
<?php

require_once '../vendor/autoload.php';

racoin\app\App::DbConf('../src/racoin/utils/config.ini');

use \racoin\api\controller as Controller;

$app = new \Slim\App();

//Toutes les actions pour 'catégories'
$app->group('/categories', function () use ($app) {

    //Retourne la liste des catégories
    $app->get('', function ($req, $res) use ($app) {

        $controller = new Controller\CategorieController($req, $res, $app);
        return $controller->getAllCategories();
    });

    //Retourne la catégorie demandée
    $app->get('/{id}', function ($req, $res, $args) use ($app) {

        $id = $args['id'];
        $controller = new Controller\CategorieController($req, $res, $app);
        return $controller->getCategorieById($id);
    });

    //Retourne les annonces d'une catégorie
    $app->get('/{id}/annonces', function ($req, $res, $args) use ($app) {

        $id = $args['id'];
        $controller = new Controller\AnnonceController($req, $res, $app);
        return $controller->getAnnonceByCategorie($id);
    });

    //Post d'annonce sur une catégorie
    $app->post('/{id}/annonce', function ($req, $res, $args) use ($app) {
        $id = $args['id'];
        $controller = new Controller\AnnonceController($req, $res, $app);
        return $controller->postAnnonce($id);
    });
});

//Toutes les actions pour 'annonces'
$app->group('/annonces', function () use ($app) {

    //Retourne la liste des annonces
    $app->get('', function ($req, $res, $app) use ($app) {

        $annonces = new Controller\AnnonceController($req, $res, $app);
        return $annonces->getAllAnnonces();
    });

    //Retourne l'annonce demandée
    $app->get('/{id}', function ($req, $res, $args) use ($app) {

        $id = $args['id'];
        $controller = new Controller\AnnonceController($req, $res, $app);
        return $controller->getAnnonceById($id);
    });

    //Retourne la catégorie de l'annonce demandée
    $app->get('/{id}/categorie', function ($req, $res, $args) use ($app) {

        $id = $args['id'];
        $controller = new Controller\CategorieController($req, $res, $app);
        return $controller->getCategorieByAnnonce($id);
    });

    //Supprime une annonce
    $app->delete('/{id}', function ($req, $res, $args) use ($app) {

        $id = $args['id'];
        $controller = new Controller\AnnonceController($req, $res, $app);
        return $controller->deleteAnnonceById($id);
    });

    //Retourne les coordonnées de l'annonceur sur l'annonce demandée
    $app->get('/{id}/annonceur', function ($req, $res, $args) use ($app) {

        $id = $args['id'];
        $controller = new Controller\AnnonceController($req, $res, $app);
        return $controller->getAnnonceur($id);
    });

    //Création d'une annonce
    $app->post('', function ($req, $res) use ($app) {

        $createdannounce = new Controller\AnnonceController($req, $res, $app);
        return $createdannounce->postAnnonce();
    });
});

$app->run();
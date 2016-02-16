<?php

namespace racoin\app;

use Illuminate\Database\Capsule\Manager as DB;

class App{

    /*** Configuration de la connexion à la base de données ***/
    public static function DbConf($filename){

        /*** Chargement du fichier utils/config.ini ***/
        $config = parse_ini_file($filename);

        if(!$config){
            throw new \Exception("App::EloConfigure could not parse config ini file $filename <br/>");
        }

        $capsule = new DB();
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
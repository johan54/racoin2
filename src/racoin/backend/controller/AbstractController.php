<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 12/02/16
 * Time: 15:40
 */

namespace racoin\backend\controller;


abstract class AbstractController
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }


    public function error($tab)
    {
        $template = $this->app->getContainer()->get('twig')->loadTemplate('error.html');
        return $template->render(array('error' => $tab));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10/12/15
 * Time: 15:01
 */

namespace racoin\api\controller;


abstract class AbstractController
{
    protected $request, $response, $app;
    public function __construct($req, $res, $app)
    {
        $this->request = $req;
        $this->response = $res;
        $this->app = $app;
    }
    public function jsonResponse($data, $status)
    {
        $encoded = json_encode($data);

        return $this->response->withStatus($status)->withHeader('Content-Type', 'application/json')->write($encoded);

    }
}
<?php

namespace bin\controllers;

use bin\http\Http;

abstract class Controller {

    /**
    * @var Object Http request
    *
    */
    protected $request;

    /**
    * All HTTP header concerning server
    * @var object $server
    */
    protected $server;

    public function __construct()
    {
        $this->request = Http::getHttp();
        $this->server = Http::getServer();
    }
}

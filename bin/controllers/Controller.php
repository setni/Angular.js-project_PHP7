<?php

namespace bin\controllers;

use bin\http\Http;

abstract class Controller {

    /**
    * @var Object Http request
    *
    */
    protected $request;

    protected $server;

    public function __construct()
    {
        $this->request = Http::getHttp();
        $this->server = Http::getServer();
    }
}

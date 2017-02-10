<?php

/***********************************************************************************************
 * Angular->php standard web service - Full native php web service Angular friendly
 *   Http.php Treatement of http request as object
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

namespace bin\http;

final class Http {

    /**
    * The Post or Get request
    * @var object $request
    */
    private static $request;

    /**
    * All HTTP header concerning server
    * @var object $server
    */
    public static $server;

    /**
    * @var object $instance
    */
    private static $instance;

    public static function getInstance()
    : self
    {
        if(is_null(static::$instance)) {
            static::$instance = new self;
        }
        return static::$instance;
    }

    private function __construct()
    {
        static::_server();
    }

    private static function _server()
    : void
    {
        static::$server = (object) $_SERVER;
    }


    /**
    * set http request (POST and GET)
    * @param object $request
    */
    public static function setHttp(\stdClass $request)
    : self
    {
        static::$request = $request;
        return static::$instance;
    }

    /**
    * parse the rest parameters
    * @param string $uri
    */
    public static function parseURI(string $uri)
    : self
    {
        $parse = explode("/", $uri);
        $lenght = count($parse);
        static::$request->controller = $parse[$lenght-3];
        static::$request->action = $parse[$lenght-2];
        return static::$instance;
    }

    /**
    * get http request (POST and GET)
    */
    public static function getHttp()
    : \stdClass
    {
        return static::$request;
    }

    /**
    * set http server variable
    */
    public static function getServer()
    : \stdClass
    {
        return static::$server;
    }

}

<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
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
    public static $server;

    /**
    * @var object $instance
    */
    private static $instance;

    public static function getInstance()
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
    {
        static::$server = (object) $_SERVER;
    }

    /**
    * set http request (POST and GET)
    * @param object $request
    * @return instance of class
    */
    public static function setHttp($request)
    {
        static::$request = $request;
        return static::$instance;
    }

    /**
    * get http request (POST and GET)
    * @return $request
    */
    public static function getHttp()
    {
        return static::$request;
    }

    /**
    * set http server variable
    * @return $server
    */
    public static function getServer()
    {
        return static::$server;
    }

}

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
    * @var object $request
    */
    private static $request;

    /**
    * @var object $instance
    */
    private static $_instance;

    public static function getInstance()
    {
        if(is_null(static::$_instance)) {
            static::$_instance = new self;
        }
        return static::$_instance;
    }

    /**
    * @param object $request
    * @return instance of class
    */
    public static function setHttp($request)
    {
        static::$request = $request;
        return static::$_instance;
    }

    /**
    * @return $request
    */
    public static function getHttp()
    {
        return static::$request;
    }
}

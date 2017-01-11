<?php

namespace http;

class Http {
  private static $request;
  private static $_instance;

  public static function getInstance()
  {
    if(is_null(static::$_instance)) {
      static::$_instance = new Http();
    }

    return static::$_instance;
  }

  public static function setHttp($request)
  {
      static::$request = $request;
      return static::$_instance;
  }

  public static function getHttp()
  {
      return static::$request;
  }
}

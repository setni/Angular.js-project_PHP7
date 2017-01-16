<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   Log.php log management, used as service
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

namespace bin\log;

final class Log implements LoggerInterface{

    /**
    * @var Object Log()
    *
    */
    private static $instance;

    /**
    * @var string $message
    *
    */
    private static $message;

    private function __construct()
	{
	}

    private static function _getInstance ()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self;
        }
    }

    /**
    * @param string $message
    * @param array $context
    * @return $instance
    */
    public static function error ($message, array $context = [])
    {
        self::_getInstance();
        self::_interpolate($message, $context);
        $error = var_export($message, true);
        $date = date('l jS \of F Y h:i:s A');
        $date = var_export($date, true);

        file_put_contents(LOG_ERROR_FILE, "Error Trigger at $date: ".$error."\n", FILE_APPEND);
        return self::$instance;
    }

    /**
    * @param string $message
    * @param array $context
    * @return $instance
    */
    public static function debug ($message, array $context = [])
    {
        if(DEBUG) {
            self::_getInstance();
            self::_interpolate($message, $context);
            return self::$instance;
        }
    }

    /**
    * @param string $message
    * @param array $context
    * @return $instance
    */
    public static function warning ($message, array $context = [])
    {
        self::_getInstance();
        self::_interpolate($message, $context);
        return self::$instance;
    }

    public function __toString()
    {
        return self::$message;
    }

    private static function _interpolate (&$message, $context)
    {
        $replace = [];
        foreach ($context as $index => $type) {
            if (!is_array($type) && (!is_object($type) || method_exists($type, '__toString'))) {
                $replace['{' . $index . '}'] = $type;
            }
        }
        $message = strtr($message, $replace);
        self::$message = $message;
    }
}

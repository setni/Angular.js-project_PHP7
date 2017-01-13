<?php

/***********************************************************************************************
 * Angular->php standard REST API  - Full native php REST API Angular friendly
 *   LoggerInterface.php PSR-3 full complaiance
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

namespace bin\log;

interface LoggerInterface
{
    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return $message
     */
    public static function error($message, array $context);

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return $message
     */
    public static function debug($message, array $context);

    /**
     * Not blocking error.
     *
     * @param string $message
     * @param array $context
     * @return $message
     */
    public static function warning($message, array $context);
}

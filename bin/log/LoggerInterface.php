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
     * @param $message
     * @param $context
     */
    public static function error(string $message, array $context = [])
    : Log;

    /**
     * Detailed debug information.
     *
     * @param $message
     * @param $context
     */
    public static function debug(string $message, array $context = [])
    : Log;

    /**
     * Not blocking error.
     *
     * @param $message
     * @param $context
     */
    public static function warning(string $message, array $context = [])
    : Log;
}

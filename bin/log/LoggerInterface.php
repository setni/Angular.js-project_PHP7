<?php

namespace log;

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

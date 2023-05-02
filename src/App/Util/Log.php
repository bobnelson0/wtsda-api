<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-02-06
 * Time: 2:41 PM
 */

namespace App\Util;


use Monolog\Logger;
use Monolog\Handler\NullHandler;
//use Monolog\Handler\StreamHandler;
//use Monolog\Handler\BrowserConsoleHandler;
//use Monolog\Handler\ChromePHPHandler;
//use Monolog\Handler\FirePHPHandler;

class Log {

    public static function log($level, $object, $context = array()) {
        var_dump($object);exit;
        $configFile = __DIR__ . '/../../config/local.ini';
        $log = new Logger(Config::getKey($configFile, 'log.name'));

        $filePath = Config::getKey($configFile,'log.file_path') .
            Config::getKey($configFile,'log.file_prefix') .
            date('Y-m-d') .
            Config::getKey($configFile,'log.file_suffix');
        $logLevel = constant('Logger::' . Config::getKey($configFile,'log.level'));

        //$log->pushHandler(new StreamHandler($filePath, $logLevel));
        $log->pushHandler(new NullHandler($logLevel));

        $log->log($level, $object, $context);
    }

    public static function debug($object, $context = array()) {
        static::log(Logger::DEBUG, $object, $context);
    }

    public static function info($object, $context = array()) {
        static::log(Logger::INFO, $object, $context);
    }

    public static function notice($object, $context = array()) {
        static::log(Logger::NOTICE, $object, $context);
    }

    public static function warning($object, $context = array()) {
        static::log(Logger::WARNING, $object, $context);
    }

    public static function error($object, $context = array()) {
        static::log(Logger::ERROR, $object, $context);
    }

    public static function critical($object, $context = array()) {
        static::log(Logger::CRITICAL, $object, $context);
    }

    public static function alert($object, $context = array()) {
        static::log(Logger::ALERT, $object, $context);
    }

    public static function emergency($object, $context = array()) {
        static::log(Logger::EMERGENCY, $object, $context);
    }
}
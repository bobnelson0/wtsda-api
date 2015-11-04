<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-02-06
 * Time: 1:24 PM
 */

namespace App\Util;


class Config {

    public static function getSection($file, $section) {
        $config = parse_ini_file($file, $parseSections = true);

        if(!empty($section) && is_string(($section))) {
            return isset($config[$section]) ? $config[$section] : array();
        } else {
            $val = print_r($section, 1);
            throw new \InvalidArgumentException("section must be a string and not empty. $val passed.");
        }
    }

    public static function getKey($file, $keyStr) {
        $config = parse_ini_file($file, $parseSections = true);

        $parts = array();
        if(is_string($keyStr) && !empty($keyStr)) {
            $parts = explode('.', $keyStr);
            $section = $parts[0];
            $key = $parts[1];
        }

        if(count($parts) == 2 && is_string($section) && is_string($key)) {
            return isset($config[$section][$key]) ? $config[$section][$key] : null;
        } else {
            $val = print_r($keyStr, 1);
            throw new \InvalidArgumentException("section must be a string and not empty. $val passed.");
        }
    }
}
<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-09
 * Time: 4:34 PM
 */
namespace App\Util;

class Validation {

    public static function isValidOrd($param) {
        if(is_object($param) || is_array($param) || intval($param) < 1) {
            return false;
        }
        return true;
    }
}
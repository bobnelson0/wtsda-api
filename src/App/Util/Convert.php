<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-02-17
 * Time: 2:07 PM
 */

namespace App\Util;


class Convert {

    public static function stringToBool($val) {
        $trueVals = array(
            true,
            'true',
            't',
            'yes',
            'y',
            1,
            '1'
        );
        $falseVals = array(
            false,
            'false',
            'f',
            'no',
            'n',
            0,
            '0');
        $val = strtolower($val);
        if(in_array($val, $trueVals)) {
            return true;
        } else if(in_array($val, $falseVals)) {
            return false;
        } else {
            //TODO
            throw new \InvalidArgumentException('TODO');
        }
    }
}
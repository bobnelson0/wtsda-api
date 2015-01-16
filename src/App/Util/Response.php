<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-09
 * Time: 4:53 PM
 */
namespace App\Util;

/**
 * Class Response
 * @package App\Util
 */
class Response {

    public static function getResponseData($code, $message, $key, $data) {

        if($code >= 400 && $code <= 499) {
            $status = 'failure';
        } else if($code >= 500 && $code <= 599) {
            $status = 'error';
        } else {
            $status = 'success';
        }

        return array(
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => array($key => $data)
        );

    }
}
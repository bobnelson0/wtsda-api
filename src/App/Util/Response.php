<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-09
 * Time: 4:53 PM
 */
namespace App\Util;
use App\Resource;

/**
 * Class Response
 * @package App\Util
 */
class Response {

    public static function getResponseData($code, $message, $key, $data) {

        if($code >= 400 && $code <= 499) {
            // TODO : put in logic to out put error in dev
            $status = 'failure';
        } else if($code >= 500 && $code <= 599) {
            // TODO : put in logic to out put error in dev
            $status = 'error';
        } else {
            // Give an entity link after creation, in the event its blank, return nothing.
            if($code == Resource::STATUS_CREATED) {
                if(isset($data['links'])) {
                    $data =  array('links' => $data['links']);
                } else {
                    $data = array();
                }
            } else {
                $data = array($key => $data);
            }
            $status = 'success';
        }

        return array(
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data
        );

    }
}
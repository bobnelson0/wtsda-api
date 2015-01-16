<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-09
 * Time: 4:34 PM
 */
namespace App\Util;

/**
 * Class Request
 * @package App\Util
 */
class Request {

    public static function getRequestCriteria(array $params, \Slim\Http\Headers $headers)
    {
        echo print_r($params, true);
        echo print_r($headers, true);

        $criteria = array();
        //Range, query string takes precedence
        $offset = $params['offset'];
        $limit = $params['limit'];
        $range = $headers->get('Range');
        $criteria = array_merge($criteria, self::getRange($offset, $limit, $range));

        echo print_r($criteria, true);

        return $criteria;
    }

    public static function getRange($offset, $limit, $rangeHeader) {
        $range = array();
        if(!empty($offset) && !empty($limit) &&
            is_int($offset) && is_int($limit)) {
            $range['offset'] = $offset;
            $range['limit'] = $limit;
        } else if(!empty($rangeHeader) && !is_null($rangeHeader)) {

            //TODO: Fix 0-B range
            $parsed = explode('-', $rangeHeader);
            $range['offset'] = $parsed['0'];
            $range['limit'] = $parsed['1'] - $parsed['0'];
        } else {
            $range['offset'] = 0;
            $range['limit'] = null;
        }
        return $range;
    }

    public static function getSort($sortStr) {

    }

    public static function getFilter($filterStr) {

    }
}
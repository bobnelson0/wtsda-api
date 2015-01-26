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

    /**
     * Default offset if none is passed or the passed value is invalid
     *
     * @var int
     */
    protected static $defaultOffset = 0;

    /**
     * Default limit if none is passed or the passed value is invalid
     *
     * @var int
     */
    protected static $defaultLimit = 25;

    public static function getDefaultOffset() {
        return self::$defaultOffset;
    }

    public static function getDefaultLimit() {
        return self::$defaultLimit;
    }

    public static function getRequestCriteria(array $params, \Slim\Http\Headers $headers)
    {
        //echo print_r($params, true);
        //echo print_r($headers, true);

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

        if(!is_null($offset) && !is_null($limit)) {
            return self::getRangeFromParams($offset, $limit);
        } else if(!is_null($rangeHeader)) {
            return self::getRangeFromHeader($rangeHeader);
        }

        $range['offset'] = self::getDefaultOffset();
        $range['limit'] = self::getDefaultLimit();

        return $range;
    }

    protected static function getRangeFromParams($offset, $limit) {
        $offsetIsInt = filter_var($offset, FILTER_VALIDATE_INT) !== false;
        $limitIsInt = filter_var($limit, FILTER_VALIDATE_INT) !== false;

        if($offsetIsInt && $limitIsInt && $offset >=0 && $limit >= 1) {
            $range['offset'] = $offset;
            $range['limit'] = $limit;
            return $range;
        }
        throw new \InvalidArgumentException("offset & limit must be integers. offset($offset), limit($limit) given.");
    }

    protected static function getRangeFromHeader($rangeHeader) {
        if(substr_count($rangeHeader, '-') == 1) {
            $parsedRange = explode('-', $rangeHeader);

            if (count($parsedRange) == 2) {
                $offset = $parsedRange[0];
                $limit = $parsedRange[1];

                //Validates each value is an integer
                $offsetIsInt = filter_var($offset, FILTER_VALIDATE_INT) !== false;
                $limitIsInt = filter_var($limit, FILTER_VALIDATE_INT) !== false;

                if ($offsetIsInt && $limitIsInt) {
                    $range['offset'] = $offset;
                    $range['limit'] = $limit - $offset + 1;
                    return $range;
                }
            }
        }
        throw new \InvalidArgumentException("offset & limit must be integers. offset($offset), limit($limit) given.");
    }

    public static function getSort($sortStr) {

    }

    public static function getFilter($filterStr) {

    }
}
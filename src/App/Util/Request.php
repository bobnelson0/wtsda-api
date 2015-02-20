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
        $criteria = array();
        //Range, query string takes precedence
        $offset = isset($params['offset']) ? $params['offset'] : null;
        $limit = isset($params['limit']) ? $params['limit'] : null;
        $range = $headers->get('Range');
        $sorts = isset($params['sorts']) ? self::getSorts($params['sorts']) : array();
        $filters = isset($params['filters']) ? self::getFilters($params['filters']) : array();
        $criteria = array_merge(
            $criteria,
            self::getRange($offset, $limit, $range),
            $sorts,
            $filters
        );

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
                    $range['limit'] = $limit - $offset;
                    return $range;
                }
            }
        }
        throw new \InvalidArgumentException("offset & limit must be integers. offset($offset), limit($limit) given.");
    }

    public static function getSorts($sortStr) {
        //sort= last_name|first_name|-hire_date
        if(is_object($sortStr) || is_array($sortStr)) {
            $type = gettype($sortStr);
            throw new \InvalidArgumentException("sorts must be given as a string, $type given instead");
        }
        $sortArr = array();
        $sorts = explode('|', $sortStr);
        foreach($sorts as $sort) {
            $dir = 'asc';
            $first = substr($sort, 0, 1);
            if($first == '-') {
                $dir = 'desc';
                $sort = substr($sort, 1);
            }
            if(empty($sort) || preg_match('/[^a-z0-9]/i', $sort)) {
                throw new \InvalidArgumentException("sort field must be alphanumeric");
            }
            $sortArr['sorts'][] = array(
                'sort' => $sort,
                'dir' => $dir);
        }
        return $sortArr;
    }

    public static function getFilters($filterStr) {
        //filter= name::todd|city::denver|title::sir
        if(is_object($filterStr) || is_array($filterStr)) {
            $type = gettype($filterStr);
            throw new \InvalidArgumentException("filters must be given as a string, $type given instead");
        }
        $allowedOps = array(
            '::' => '=',
            ':<>:' => '<>',
            ':-:' => 'LIKE',
            ':>:' => '>',
            ':>-:' => '>=',
            ':<-:' => '<='
        );
        $delimiter = null;
        $operand = null;

        $filterArr = array();
        $filters = explode('|', $filterStr);

        foreach($filters as $filter) {
            foreach($allowedOps as $sym => $op) {
                $pos = strpos($filter, $sym);
                if($pos !== false) {
                    $delimiter = $sym;
                    $operand = $op;
                    break;
                }
            }
            if($delimiter == null || $operand == null) {
                throw new \InvalidArgumentException("filter delimiter ('$delimiter') and/or operand ('$operand') not recognized");
            }

            $parts = explode($delimiter, $filter);

            if(count($parts) != 2 || empty($parts[0]) || $parts[1] == '') {
                throw new \InvalidArgumentException("malformed filter ('$filter')");
            }

            $filter = $parts[0];
            $val = $parts[1];
            $filterArr['filters'][] = array(
                'filter' => $filter,
                'val' => $val,
                'op' => $operand
            );
        }
        return $filterArr;
    }
}
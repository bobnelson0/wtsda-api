<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 2:11 PM
 */
namespace App\Resource;

use App\Resource;
use App\Service\DojangPhoneNumbers as DojangPhoneNumbersService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;

/**
 * Class DojangPhoneNumbers
 * @package App\Resource
 */
class DojangPhoneNumbers extends Resource
{
    /**
     * @var string
     */
    protected $key = 'dojangPhoneNumbers';

    /**
     * @var \App\Service\DojangPhoneNumbers
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new DojangPhoneNumbersService($this->getEntityManager()));
    }

    /**
     * Get one or more DojangPhoneNumber entities
     * $id specifies a specific entity
     * If entity with $id is not found, 404: Not Found Returned
     *
     * @param null | $id ID of the desire entity
     */
    public function get($id = null)
    {
        try {
            if ($id === null) {
                $criteria = Request::getRequestCriteria(
                    $this->getSlim()->request()->params(),
                    $this->getSlim()->request()->headers()
                );
                $data = $this->getService()->getDojangPhoneNumbers($criteria);
            } else {
                $data = $this->getService()->getDojangPhoneNumber($id);
            }
        } catch(\Exception $e) {
            self::sendException($e);
            return;
        }

        if ($data === null) {
            self::response(self::STATUS_NOT_FOUND, $this->formatResponse(self::STATUS_NOT_FOUND, $data,'rank group not found'));
            return;
        }

        self::response(self::STATUS_OK, $this->formatResponse(self::STATUS_OK, $data));
    }

    /**
     * Show options in header
     */
    public function options()
    {
        self::response(self::STATUS_OK, array(), array('GET', 'OPTIONS'));
    }

    /**
     * @return \App\Service\DojangPhoneNumbers
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\DojangPhoneNumbers $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
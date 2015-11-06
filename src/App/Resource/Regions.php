<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 1:11 PM
 */
namespace App\Resource;

use App\Resource;
use App\Service\Regions as RegionsService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;

/**
 * Class Regions
 * @package App\Resource
 */
class Regions extends Resource
{
    /**
     * @var string
     */
    protected $key = 'regions';

    /**
     * @var \App\Service\Regions
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new RegionsService($this->getEntityManager()));
    }

    /**
     * Get one or more Region entities
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
                $data = $this->getService()->getRegions($criteria);
            } else {
                $data = $this->getService()->getRegion($id);
            }
        } catch(\Exception $e) {
            static::sendException($e);
            return;
        }

        if ($data === null) {
            static::response(static::STATUS_NOT_FOUND, $this->formatResponse(static::STATUS_NOT_FOUND, $data,'region not found'));
            return;
        }

        static::response(static::STATUS_OK, $this->formatResponse(static::STATUS_OK, $data));
    }

    /**
     * Create a new Region entity
     */
    public function post()
    {
        $number = $this->getSlim()->request()->params('number');
        $description = $this->getSlim()->request()->params('description');
        $ord = intval($this->getSlim()->request()->params('ord'));

        if (empty($number) || empty($description) || empty($ord)) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $data = $this->getService()->createRegion($number, $description, $ord);
        } catch (DBALException $e) {
            static::response(static::STATUS_CONFLICT, array('data' => array('conflict')));
            return;
        }

        static::response(static::STATUS_CREATED, array('data' => $data));
    }

    /**
     * Update Region
     *
     * @param $id
     */
    public function put($id)
    {
        $number = $this->getSlim()->request()->params('number');
        $description = $this->getSlim()->request()->params('description');
        $ord = intval($this->getSlim()->request()->params('ord'));

        if (empty($number) || empty($description) || empty($ord)) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        $data = $this->getService()->updateRegion($id, $number, $description, $ord);

        if ($data === null) {
            static::response(static::STATUS_NOT_IMPLEMENTED);
            return;
        }

        static::response(static::STATUS_NO_CONTENT);
    }

    /**
     * Delete an Region Entity
     *
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->getService()->deleteRegion($id);

        if ($status === false) {
            static::response(static::STATUS_NOT_FOUND);
            return;
        }

        static::response(static::STATUS_OK);
    }

    /**
     * Show options in header
     */
    public function options()
    {
        static::response(static::STATUS_OK, array(), array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'));
    }

    /**
     * @return \App\Service\Regions
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\Regions $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
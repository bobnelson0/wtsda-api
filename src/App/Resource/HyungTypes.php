<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 12:38 PM
 */

namespace App\Resource;

use App\Resource;
use App\Service\HyungTypes as HyungTypesService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;

class HyungTypes extends Resource
{
    /**
     * @var string
     */
    protected $key = 'hyung_types';

    /**
     * @var \App\Service\HyungTypes
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new HyungTypesService($this->getEntityManager()));
    }

    /**
     * Get one or more HyungType entities
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
                $data = $this->getService()->getHyungTypes($criteria);
            } else {
                $data = $this->getService()->getHyungType($id);
            }
        } catch(\Exception $e) {
            static::sendException($e);
            return;
        }

        if ($data === null) {
            static::response(static::STATUS_NOT_FOUND, $this->formatResponse(static::STATUS_NOT_FOUND, $data,'hyung type not found'));
            return;
        }

        static::response(static::STATUS_OK, $this->formatResponse(static::STATUS_OK, $data));
    }

    /**
     * Create a new HyungType entity
     */
    public function post()
    {
        $name = $this->getSlim()->request()->params('name');

        if (empty($name) || $name === null) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $data = $this->getService()->createHyungType($name);
        } catch (DBALException $e) {
            static::response(static::STATUS_CONFLICT, array('data' => array('conflict')));
            return;
        }

        static::response(static::STATUS_CREATED, array('data' => $data));
    }

    /**
     * Update HyungType
     *
     * @param $id
     */
    public function put($id)
    {
        $name = $this->getSlim()->request()->params('name');

        if (empty($name) || $name === null) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        $data = $this->getService()->updateHyungType($id, $name);

        if ($data === null) {
            static::response(static::STATUS_NOT_IMPLEMENTED);
            return;
        }

        static::response(static::STATUS_NO_CONTENT);
    }

    /**
     * Delete an HyungType Entity
     *
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->getService()->deleteHyungType($id);

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
     * @return \App\Service\HyungTypes
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\HyungTypes $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
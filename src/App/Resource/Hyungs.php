<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 12:28 PM
 */

namespace App\Resource;

use App\Resource;
use App\Service\Hyungs as HyungService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;

class Hyungs extends Resource
{
    /**
     * @var string
     */
    protected $key = 'hyungs';

    /**
     * @var \App\Service\Hyungs
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new HyungService($this->getEntityManager()));
    }

    /**
     * Get one or more Hyung entities
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
                $data = $this->getService()->getHyungs($criteria);
            } else {
                $data = $this->getService()->getHyung($id);
            }
        } catch(\Exception $e) {
            static::sendException($e);
            return;
        }

        if ($data === null) {
            static::response(static::STATUS_NOT_FOUND, $this->formatResponse(static::STATUS_NOT_FOUND, $data,'hyung not found'));
            return;
        }

        static::response(static::STATUS_OK, $this->formatResponse(static::STATUS_OK, $data));
    }

    /**
     * Create a new Hyung entity
     */
    public function post()
    {
        $name = $this->getSlim()->request()->params('name');
        $ord = intval($this->getSlim()->request()->params('ord'));

        if (empty($name) || empty($ord) || $name === null || $ord === null) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $data = $this->getService()->createHyung($name, $ord);
        } catch (DBALException $e) {
            static::response(static::STATUS_CONFLICT, array('data' => array('conflict')));
            return;
        }

        static::response(static::STATUS_CREATED, array('data' => $data));
    }

    /**
     * Update Hyung
     *
     * @param $id
     */
    public function put($id)
    {
        $name = $this->getSlim()->request()->params('name');
        $ord = $this->getSlim()->request()->params('ord');

        if (empty($name) || empty($ord) || $name === null || $ord === null) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        $data = $this->getService()->updateHyung($id, $name, $ord);

        if ($data === null) {
            static::response(static::STATUS_NOT_IMPLEMENTED);
            return;
        }

        static::response(static::STATUS_NO_CONTENT);
    }

    /**
     * Delete an Hyung Entity
     *
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->getService()->deleteHyung($id);

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
     * @return \App\Service\Hyungs
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\Hyungs $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Resource;

use App\Resource;
use App\Service\Dojangs as DojangsService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;

/**
 * Class Dojangs
 * @package App\Resource
 */
class Dojangs extends Resource
{
    /**
     * @var string
     */
    protected $key = 'dojangs';

    /**
     * @var \App\Service\Dojangs
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new DojangsService($this->getEntityManager()));
    }

    /**
     * Get one or more Dojang entities
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
                $data = $this->getService()->getDojangs($criteria);
            } else {
                $data = $this->getService()->getDojang($id);
            }
        } catch(\Exception $e) {
            static::sendException($e);
            return;
        }

        if ($data === null) {
            static::response(static::STATUS_NOT_FOUND, $this->formatResponse(static::STATUS_NOT_FOUND, $data,'dojang not found'));
            return;
        }

        static::response(static::STATUS_OK, $this->formatResponse(static::STATUS_OK, $data));
    }

    /**
     * Create a new Dojang entity
     */
    public function post()
    {
        $name = $this->getSlim()->request()->params('name');
        $desc = intval($this->getSlim()->request()->params('desc'));

        if (empty($name) || empty($desc)) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $data = $this->getService()->createDojang($name, $desc);
        } catch (DBALException $e) {
            static::response(static::STATUS_CONFLICT, array('data' => array('conflict')));
            return;
        }

        static::response(static::STATUS_CREATED, array('data' => $data));
    }

    /**
     * Update Dojang
     *
     * @param $id
     */
    public function put($id)
    {
        $name = $this->getSlim()->request()->params('name');
        $desc = $this->getSlim()->request()->params('desc');

        if (empty($name) || empty($desc)) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        $data = $this->getService()->updateDojang($id, $name, $desc);

        if ($data === null) {
            static::response(static::STATUS_NOT_IMPLEMENTED);
            return;
        }

        static::response(static::STATUS_NO_CONTENT);
    }

    /**
     * Delete an Dojang Entity
     *
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->getService()->deleteDojang($id);

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
     * @return \App\Service\Dojangs
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\Dojangs $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
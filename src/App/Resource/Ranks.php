<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Resource;

use App\Resource;
use App\Service\Ranks as RanksService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;

/**
 * Class Ranks
 * @package App\Resource
 */
class Ranks extends Resource
{
    /**
     * @var string
     */
    protected $key = 'ranks';

    /**
     * @var \App\Service\Ranks
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new RanksService($this->getEntityManager()));
    }

    /**
     * Get one or more Rank entities
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
                $data = $this->getService()->getRanks($criteria);
            } else {
                $data = $this->getService()->getRank($id);
            }
        } catch(\Exception $e) {
            static::sendException($e);
            return;
        }

        if ($data === null) {
            static::response(static::STATUS_NOT_FOUND, $this->formatResponse(static::STATUS_NOT_FOUND, $data,'rank not found'));
            return;
        }

        static::response(static::STATUS_OK, $this->formatResponse(static::STATUS_OK, $data));
    }

    /**
     * Create a new Rank entity
     */
    public function post()
    {
        $name = $this->getSlim()->request()->params('name');
        $ord = intval($this->getSlim()->request()->params('ord'));
        $groupId = intval($this->getSlim()->request()->params('groupId'));

        if (empty($name) || empty($ord) || empty($groupId)) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $data = $this->getService()->createRank($name, $ord, $groupId);
        } catch (DBALException $e) {
            static::response(static::STATUS_CONFLICT, array('data' => array('conflict')));
            return;
        }

        static::response(static::STATUS_CREATED, $this->formatResponse(static::STATUS_CREATED, $data));
    }

    /**
     * Update Rank
     *
     * @param $id
     */
    public function put($id)
    {
        $name = $this->getSlim()->request()->params('name');
        $ord = intval($this->getSlim()->request()->params('ord'));
        $groupId = intval($this->getSlim()->request()->params('groupId'));

        if (empty($name) || empty($ord) || empty($groupId)) {
            static::response(static::STATUS_BAD_REQUEST);
            return;
        }

        $data = $this->getService()->updateRank($id, $name, $ord, $groupId);

        if ($data === null) {
            static::response(static::STATUS_NOT_IMPLEMENTED);
            return;
        }

        static::response(static::STATUS_NO_CONTENT);
    }

    /**
     * Delete an Rank Entity
     *
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->getService()->deleteRank($id);

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
     * @return \App\Service\Ranks
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\Ranks $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }
}
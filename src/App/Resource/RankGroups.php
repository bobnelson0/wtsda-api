<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Resource;

use App\Resource;
use App\Service\RankGroups as RankGroupsService;
use App\Util\Request;
use \Doctrine\DBAL\DBALException;
use App\Util\Response;

/**
 * Class RankGroups
 * @package App\Resource
 */
class RankGroups extends Resource
{
    /**
     * @var string
     */
    protected $key = 'rank_groups';

    /**
     * @var \App\Service\RankGroups
     */
    protected $service;

    /**
     * Initialize the resource
     */
    public function init()
    {
        $this->setService(new RankGroupsService($this->getEntityManager()));
    }

    /**
     * Get one or more RankGroup entities
     * $id specifies a specific entity
     * If entity with $id is not found, 404: Not Found Returned
     *
     * @param null | $id ID of the desire entity
     */
    public function get($id = null)
    {
        if ($id === null) {
            $criteria = Request::getRequestCriteria(
                $this->getSlim()->request()->params(),
                $this->getSlim()->request()->headers()
            );
            $data = $this->getService()->getRankGroups(array());
        } else {
            $data = $this->getService()->getRankGroup($id);
        }

        if ($data === null) {
            self::response(self::STATUS_NOT_FOUND, $this->formatResponse(self::STATUS_NOT_FOUND, $data,'Rank Group Not Found'));
            return;
        }

        self::response(self::STATUS_OK, $this->formatResponse(self::STATUS_OK, $data));
    }

    /**
     * Create a new RankGroup entity
     */
    public function post()
    {
        $name = $this->getSlim()->request()->params('name');
        $ord = intval($this->getSlim()->request()->params('ord'));

        if (empty($name) || empty($ord) || $name === null || $ord === null) {
            self::response(self::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $rankGroup = $this->getService()->createRankGroup($name, $ord);
        } catch (DBALException $e) {
            self::response(self::STATUS_CONFLICT, array('data' => array('Conflict')));
            return;
        }

        self::response(self::STATUS_CREATED, array('data' => $rankGroup));
    }

    /**
     * Update RankGroup
     *
     * @param $id
     */
    public function put($id)
    {
        $name = $this->getSlim()->request()->params('name');
        $ord = $this->getSlim()->request()->params('ord');

        if (empty($name) || empty($ord) || $name === null || $ord === null) {
            self::response(self::STATUS_BAD_REQUEST);
            return;
        }

        $rankGroup = $this->getService()->updateRankGroup($id, $name, $ord);

        if ($rankGroup === null) {
            self::response(self::STATUS_NOT_IMPLEMENTED);
            return;
        }

        self::response(self::STATUS_NO_CONTENT);
    }

    /**
     * Delete an RankGroup Entity
     *
     * @param $id
     */
    public function delete($id)
    {
        $status = $this->getService()->deleteRankGroup($id);

        if ($status === false) {
            self::response(self::STATUS_NOT_FOUND);
            return;
        }

        self::response(self::STATUS_OK);
    }

    /**
     * Show options in header
     */
    public function options()
    {
        self::response(self::STATUS_OK, array(), array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'));
    }

    /**
     * @return \App\Service\RankGroups
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\RankGroups $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function formatResponse($code, $data, $message = null){
        return Response::getResponseData($code, $message, $this->key, $data);
    }
}
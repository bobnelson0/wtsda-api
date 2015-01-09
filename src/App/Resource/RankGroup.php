<?php

namespace App\Resource;

use App\Resource;
use App\Service\RankGroup as RankGroupService;

class RankGroup extends Resource
{
    /**
     * @var \App\Service\RankGroup
     */
    private $service;

    /**
     * Initialize the resource
     *
     * 1. Get rank group service
     */
    public function init()
    {
        $this->setService(new RankGroupService($this->getEntityManager()));
    }

    /**
     * Get one or more RankGroup entities
     * $id specifies a specific entity
     * If entity with $id is not found, 404: Not Found Returned
     *
     * @param null $id
     */
    public function get($id = null)
    {
        if ($id === null) {
            $data = $this->getService()->getRankGroups();
        } else {
            $data = $this->getService()->getRankGroup($id);
        }

        if ($data === null) {
            self::response(self::STATUS_NOT_FOUND);
            return;
        }

        $response = array('data' => $data);
        self::response(self::STATUS_OK, $response);
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
        } catch (\Doctrine\DBAL\DBALException $e) {
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
     * @return \App\Service\User
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \App\Service\RankGroup $service
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
}
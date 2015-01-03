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
     * Get rank group service
     */
    public function init()
    {
        $this->setService(new RankGroupService($this->getEntityManager()));
    }

    /**
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

        $response = array('rank_group' => $data);
        self::response(self::STATUS_OK, $response);
    }

    /**
     * Create user
     */
    public function post()
    {

    }

    /**
     * Update user
     */
    public function put($id)
    {

    }

    /**
     * @param $id
     */
    public function delete($id)
    {

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
     * @param \App\Service\RankGroup $rankGroupService
     */
    public function setService($rankGroupService)
    {
        $this->service = $rankGroupService;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
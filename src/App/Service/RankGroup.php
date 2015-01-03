<?php

namespace App\Service;

use App\Service;

class RankGroup extends Service
{
    /**
     * @param $id
     * @return object
     */
    public function getRankGroup($id)
    {
        /**
         * @var \App\Entity\RankGroup $rankGroup
         */
        $repository = $this->getEntityManager()->getRepository('App\Entity\RankGroup');
        $rankGroup = $repository->find($id);

        if ($rankGroup === null) {
            return null;
        }

        return array(
            'id' => $rankGroup->getId(),
            'name' => $rankGroup->getName(),
            'ord' => $rankGroup->getOrd(),
            'created_at' => $rankGroup->getCreated(),
            'updated_at' => $rankGroup->getUpdated()
        );
    }

    /**
     * @return array|null
     */
    public function getRankGroups()
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\RankGroup');
        $rankGroups = $repository->findAll();

        if (empty($rankGroups)) {
            return null;
        }

        /**
         * @var \App\Entity\RankGroup $rankGroup
         */
        $data = array();
        foreach ($rankGroups as $rankGroup)
        {
            $data[] = array(
                'id' => $rankGroup->getId(),
                'name' => $rankGroup->getName(),
                'ord' => $rankGroup->getOrd(),
                'created_at' => $rankGroup->getCreated(),
                'updated_at' => $rankGroup->getUpdated()
            );
        }

        return $data;
    }
}
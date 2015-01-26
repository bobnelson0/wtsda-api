<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Service;

use App\Service;

/**
 * Class RankGroups
 * @package App\Service
 */
class RankGroups extends Service
{
    protected $defaultSort = 'ord';

    /**
     * @param $id
     * @return array
     */
    public function getRankGroup($id)
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\RankGroup');
        $rankGroup = $repository->find($id);

        if ($rankGroup === null) {
            return null;
        }
        
        return $this->formatData($rankGroup);
    }

    /**
     * @param $params array list of query params (sort, limit, etc)
     * @return array|null
     */
    public function getRankGroups($params = array())
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\RankGroup');
        if(!empty($params)) {
            $criteria = array();
            foreach($params as $param) {
                switch($param) {
                    case 'sort': break;
                    case 'offset': break;
                    case 'limit': break;
                    default;
                }
            }
        }
        $rankGroups = $repository->findAll();

        if (empty($rankGroups)) {
            return null;
        }

        $data = array();
        foreach ($rankGroups as $rankGroup)
        {
            $data[] = $this->formatData($rankGroup);
        }

        return $data;
    }

    /**
     * @param $name
     * @param $ord
     * @return array
     */
    public function createRankGroup($name, $ord)
    {
        /**
         * @var \App\Entity\RankGroup $rankGroup
         */
        $rankGroup = new \App\Entity\RankGroup();
        $rankGroup->setName($name);
        $rankGroup->setOrd($ord);

        $this->persistAndFlush($rankGroup);

        return $this->formatData($rankGroup);
    }

    /**
     * @param $id
     * @param $name
     * @param $ord
     * @return array
     */
    public function updateRankGroup($id, $name, $ord)
    {
        /**
        * @var \App\Entity\RankGroup $rankGroup
        */
        $repository = $this->getEntityManager()->getRepository('App\Entity\RankGroup');
        $rankGroup = $repository->find($id);

        if ($rankGroup === null) {
            return null;
        }

        $rankGroup->setName($name);
        $rankGroup->setOrd($ord);
        $rankGroup->setUpdated(new \DateTime());

        $this->persistAndFlush($rankGroup);

        return $this->formatData($rankGroup);
    }

    public function deleteRankGroup($id)
    {
        $repository = $this->getEntityManager()->getRepository('App\Entity\RankGroup');
        $rankGroup = $repository->find($id);

        if ($rankGroup === null) {
            return false;
        }

        $this->getEntityManager()->remove($rankGroup);
        $this->getEntityManager()->flush();

        return true;
    }

    protected function formatData($data) {
        /**
         * @var \App\Entity\RankGroup $data
         */
        return array(
            'id' => $data->getId(),
            'name' => $data->getName(),
            'ord' => $data->getOrd(),
            'created_at' => $data->getCreated(),
            'updated_at' => $data->getUpdated()
        );
    }

    protected function persistAndFlush($entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
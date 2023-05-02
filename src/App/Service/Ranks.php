<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Service;

use App\Service;
use App\Util\Entity;

/**
 * Class Ranks
 * @package App\Service
 */
class Ranks extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\Rank';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'r';

    /**
     * Default filters to apply when searching on this entity
     *
     * @var array
     */
    protected $defaultFilters = array();

    /**
     * Default sorts to apply when retrieving this entity
     *
     * @var array
     */
    protected $defaultSorts = array(array('sort' => 'ord', 'dir' => 'asc'));

    /**
     * @var array
     */
    protected static $defaultEntitiesIncluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getRank($id)
    {
        /* @var \App\Entity\Rank $entity */
        $entity = Entity::findById($this->getEntityManager(), $this->entityPath, $id);

        if ($entity === null) {
            return null;
        }
        
        return static::formatData($entity);
    }

    /**
     * @param $criteria array list of query params (sort, offset, limit, etc)
     * @return array|null
     */
    public function getRanks($criteria = array())
    {
        $qb = $this->buildQuery($criteria);
        $query = $qb->getQuery();
        $entities = $query->getResult();

        if (empty($entities)) {
            return null;
        }

        $data = array();
        foreach ($entities as $entity)
        {
            $data[] = static::formatData($entity);
        }

        return $data;
    }

    /**
     * @param $name
     * @param $ord
     * @param $groupId
     * @return array
     */
    public function createRank($name, $ord, $groupId)
    {
        /**
         * @var \App\Entity\Rank $entity
         */
        $entityClass = '\\' . $this->entityPath;
        $entity = new $entityClass();
        $entity->setName($name);
        $entity->setOrd($ord);

        /* @var \App\Entity\RankGroup $rankGroup */
        $rankGroup = Entity::findById($this->getEntityManager(), 'App\Entity\RankGroup', $groupId);
        $entity->setRankGroup($rankGroup);

        $this->persistAndFlush($entity);

        return static::formatData($entity);
    }

    /**
     * @param $id
     * @param $name
     * @param $ord
     * @param $groupId
     * @return array
     */
    public function updateRank($id, $name, $ord, $groupId)
    {
        /**
        * @var \App\Entity\Rank $entity
        */
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }

        $entity->setName($name);
        $entity->setOrd($ord);
        $entity->setUpdated(new \DateTime());

        /* @var \App\Entity\RankGroup $rankGroup */
        $rankGroup = Entity::findById($this->getEntityManager(), 'App\Entity\RankGroup', $groupId);
        $entity->setRankGroup($rankGroup);

        $this->persistAndFlush($entity);

        return static::formatData($entity);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteRank($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        $entity = $repository->find($id);

        if ($entity === null) {
            return false;
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * @param \App\Entity\Rank $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true) {

        $formatted = array(
            'id' => $data->getId(),
            'name' => $data->getName(),
            'ord' => $data->getOrd(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => static::formatLink($data, 'ranks', static::LINK_RELATION_SELF),
            'relations' => array('rankGroup')
        );

        if($getRelations && static::isIncluded('rankGroup')) {
            $rankGroup = $data->getRankGroup();
            $formatted['rankGroup'] = null;
            if (!empty($rankGroup)) {
                $formatted['rankGroup'] = RankGroups::formatData($rankGroup, false);
            }
        }

        return $formatted;
    }
}
<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Service;

use App\Service;
use App\Util\Request;
use Slim\Slim;

/**
 * Class RankGroups
 * @package App\Service
 */
class RankGroups extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\RankGroup';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'rg';

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
    protected static $defaultEntitiesIncluded = array('ranks');

    /**
     * @var array
     */
    protected static $defaultEntitiesExcluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getRankGroup($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /* @var \App\Entity\RankGroup $entity */
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }
        
        return self::formatData($entity);
    }

    /**
     * @param $criteria array list of query params (sort, offset, limit, etc)
     * @return array|null
     */
    public function getRankGroups($criteria = array())
    {
        $filters = isset($criteria['filters']) ? $criteria['filters'] : $this->defaultFilters;
        $sorts = isset($criteria['sorts']) ? $criteria['sorts'] : $this->defaultSorts;
        $offset = isset($criteria['offset']) ? $criteria['offset'] : Request::getDefaultOffset();
        $limit = isset($criteria['limit']) ? $criteria['limit'] : Request::getDefaultLimit();

        $qb = $this->getEntityManager()->createQueryBuilder()
                            ->select($this->entityAlias)
                            ->from($this->entityPath, $this->entityAlias)
                            ->where('1=1')
                            ->setFirstResult($offset)
                            ->setMaxResults($limit);
        if(!empty($filters)) {
            foreach($filters as $filter) {
                $field = $this->entityAlias .'.'.$filter['filter'];
                $op = $filter['op'];
                $val = $filter['val'];
                if($op == 'LIKE') {
                    $qb->andWhere("$field LIKE '%$val%'");
                } else {
                    $qb->andWhere("$field $op '$val'");
                }
            }
        }

        if(!empty($sorts)) {
            foreach($sorts as $sort) {
                $qb->addOrderBy($this->entityAlias .'.'. $sort['sort'], $sort['dir']);
            }
        }

        $query = $qb->getQuery();
        $entities = $query->getResult();

        if (empty($entities)) {
            return null;
        }

        $data = array();
        foreach ($entities as $entity)
        {
            $data[] = self::formatData($entity);
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
         * @var \App\Entity\RankGroup $entity
         */
        $entityClass = '\\' . $this->entityPath;
        $entity = new $entityClass();
        $entity->setName($name);
        $entity->setOrd($ord);

        $this->persistAndFlush($entity);

        return self::formatData($entity);
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
        * @var \App\Entity\RankGroup $entity
        */
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }

        $entity->setName($name);
        $entity->setOrd($ord);
        $entity->setUpdated(new \DateTime());

        $this->persistAndFlush($entity);

        return self::formatData($entity);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteRankGroup($id)
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
     * @param \App\Entity\RankGroup $data
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
            'links' => self::formatLink($data, 'rankGroups', self::LINK_RELATION_SELF)
        );

        if($getRelations && self::isIncluded('ranks')) {
            $ranks = $data->getRanks();
            $formatted['ranks'] = array();
            if (!empty($ranks)) {
                foreach ($ranks as $rank) {
                    $formatted['ranks'][] = Ranks::formatData($rank, false);
                }
            }
        }

        return $formatted;
    }
}
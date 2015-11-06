<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 1:01 PM
 */
namespace App\Service;

use App\Service;
use App\Util\Request;

/**
 * Class Regions
 * @package App\Service
 */
class Regions extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\Region';

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
    public function getRegion($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /* @var \App\Entity\Region $entity */
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }

        return static::formatData($entity);
    }

    /**
     * @param $criteria array list of query params (sort, offset, limit, etc)
     * @return array|null
     */
    public function getRegions($criteria = array())
    {
        //TODO Fix filters
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
        /*        if(!empty($filters)) {
                    foreach($filters as $filter) {
                        $field = $this->entityAlias .'.'.$filter['filter'];
                        $op = $filter['op'];
                        $val = $filter['val'];
                        $qb->andWhere("$field $op '$val'");
                    }
                }*/

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
            $data[] = static::formatData($entity);
        }

        return $data;
    }

    /**
     * @param $number
     * @param $description
     * @param $ord
     * @return array
     */
    public function createRegion($number, $description, $ord)
    {
        /**
         * @var \App\Entity\Region $entity
         */
        $entityClass = '\\' . $this->entityPath;
        $entity = new $entityClass();
        $entity->setNumber($number);
        $entity->setDescription($description);
        $entity->setOrd($ord);

        $this->persistAndFlush($entity);

        return static::formatData($entity);
    }

    /**
     * @param $id
     * @param $number
     * @param $description
     * @param $ord
     * @return array
     */
    public function updateRegion($id, $number, $description, $ord)
    {
        /**
         * @var \App\Entity\Region $entity
         */
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }

        $entity->setNumber($number);
        $entity->setDescription($description);
        $entity->setOrd($ord);
        $entity->setUpdated(new \DateTime());

        $this->persistAndFlush($entity);

        return static::formatData($entity);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteRegion($id)
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
     * @param \App\Entity\Region $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true) {

        $formatted = array(
            'id' => $data->getId(),
            'number' => $data->getNumber(),
            'description' => $data->getDescription(),
            'ord' => $data->getOrd(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => static::formatLink($data, 'regions', static::LINK_RELATION_SELF)
        );

        return $formatted;
    }
}
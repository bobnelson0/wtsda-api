<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 12:32 PM
 */

namespace App\Service;

use App\Entity\HyungType;
use App\Service;
use App\Util\Request;

class Hyungs extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\Hyung';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'h';

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
    protected static $defaultEntitiesIncluded = array('hyungType');

    /**
     * @var array
     */
    protected static $defaultEntitiesExcluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getHyung($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /* @var \App\Entity\Hyung $entity */
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
    public function getHyungs($criteria = array())
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

        if (!empty($sorts)) {
            foreach ($sorts as $sort) {
                $qb->addOrderBy($this->entityAlias . '.' . $sort['sort'], $sort['dir']);
            }
        }

        $query = $qb->getQuery();
        $entities = $query->getResult();

        if (empty($entities)) {
            return null;
        }

        $data = array();
        foreach ($entities as $entity) {
            $data[] = self::formatData($entity);
        }

        return $data;
    }

    /**
     * @param $name
     * @param $ord
     * @return array
     */
    public function createHyung($name, $ord)
    {
        /**
         * @var \App\Entity\Hyung $entity
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
    public function updateHyung($id, $name, $ord)
    {
        /**
         * @var \App\Entity\Hyung $entity
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
    public function deleteHyung($id)
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
     * @param \App\Entity\Hyung $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true)
    {

        $formatted = array(
            'id' => $data->getId(),
            'name' => $data->getName(),
            'ord' => $data->getOrd(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => self::formatLink($data, 'hyungs', self::LINK_RELATION_SELF)
        );

        if ($getRelations && self::isIncluded('hyungType')) {
            $hyungType = $data->getType();
            $formatted['hyungType'] = null;
            if (!empty($hyungType)) {
                $formatted['hyungType'] = HyungTypes::formatData($hyungType, false);
            }
        }

        return $formatted;
    }
}
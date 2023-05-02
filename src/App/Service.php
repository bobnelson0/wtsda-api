<?php

namespace App;

use App\Util\Request;
use Slim\Slim;

abstract class Service
{
    const LINK_RELATION_SELF = 'self';
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'obj';

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
    protected $defaultSorts = array();

    /**
     * @var array
     */
    protected static $defaultEntitiesIncluded = array();

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Shortcut for persisting and flushing an entity
     *
     * @param \App\Entity $entity
     */
    protected function persistAndFlush($entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function buildQuery($criteria = array())
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

        return $qb;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function isIncluded($key)
    {
        //TODO Fix/Test me
        $request = Slim::getInstance()->request();
        $include = $request->params('rel');

        if(empty($include)) {
            $include = static::$defaultEntitiesIncluded;
        } else {
            $include = explode(',', $include);
        }

        if(!empty($include) && is_array($include) && in_array($key, $include)) {
            return true;
        }

        return false;
    }

    /**
     * @param \App\Entity $data
     * @param $entity
     * @param $relation
     *
     * @return array
     */
    public static function formatLink($data, $entity, $relation)
    {
        $rootUri = Slim::getInstance()->request()->getRootUri();
        $id = $data->getId();

        return array(
            'rel' => $relation,
            'href' => "$rootUri/$entity/$id"
        );
    }
}
<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 12:32 PM
 */

namespace App\Service;

use App\Service;
use App\Util\Entity;

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
    protected static $defaultEntitiesIncluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getHyung($id)
    {
        /* @var \App\Entity\Hyung $entity */
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
    public function getHyungs($criteria = array())
    {
        $qb = $this->buildQuery($criteria);
        $query = $qb->getQuery();
        $entities = $query->getResult();

        if (empty($entities)) {
            return null;
        }

        $data = array();
        foreach ($entities as $entity) {
            $data[] = static::formatData($entity);
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

        return static::formatData($entity);
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

        return static::formatData($entity);
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
            'links' => static::formatLink($data, 'hyungs', static::LINK_RELATION_SELF),
            'relations' => array('hyungType')
        );

        if ($getRelations && static::isIncluded('hyungType')) {
            $hyungType = $data->getType();
            $formatted['hyungType'] = null;
            if (!empty($hyungType)) {
                $formatted['hyungType'] = HyungTypes::formatData($hyungType, false);
            }
        }

        return $formatted;
    }
}
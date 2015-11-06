<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-05
 * Time: 3:49 PM
 */
namespace App\Service;

use App\Service;
use App\Util\Request;

/**
 * Class Profiles
 * @package App\Service
 */
class Profiles extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\Profile';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'pro';

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
    protected $defaultSorts = array(array('sort' => 'name', 'dir' => 'asc'));

    /**
     * @var array
     */
    protected static $defaultEntitiesIncluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getProfile($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /* @var \App\Entity\Profile $entity */
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
    public function getProfiles($criteria = array())
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
     * @param $desc
     * @return array
     */
    public function createProfile($name, $desc)
    {
        /**
         * @var \App\Entity\Profile $entity
         */
        $entityClass = '\\' . $this->entityPath;
        $entity = new $entityClass();
        //$entity->setName($name);
        //$entity->setDescription($desc);

        $this->persistAndFlush($entity);

        return static::formatData($entity);
    }

    /**
     * @param $id
     * @param $name
     * @param $desc
     * @return array
     */
    public function updateProfile($id, $name, $desc)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /**
         * @var \App\Entity\Profile $entity
         */
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }

        //$entity->setName($name);
        //$entity->setDescription($desc);
        $entity->setUpdated(new \DateTime());

        $this->persistAndFlush($entity);

        return static::formatData($entity);
    }

    public function deleteProfile($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /**
         * @var \App\Entity\Profile $entity
         */
        $entity = $repository->find($id);

        if ($entity === null) {
            return false;
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * @param \App\Entity\Profile $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true) {
        $formatted = array(
            'id' => $data->getId(),
            //'name' => $data->getName(),
            //'description' => $data->getDescription(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => static::formatLink($data, 'profiles', static::LINK_RELATION_SELF)
        );

        return $formatted;
    }
}
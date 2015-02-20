<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-01-08
 * Time: 11:00 AM
 */
namespace App\Service;

use App\Service;
use App\Util\Request;

/**
 * Class Dojangs
 * @package App\Service
 */
class Dojangs extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\Dojang';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'doj';

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
    protected static $defaultEntitiesIncluded = array('dojangAddresses','dojangEmailAddresses','dojangPhoneNumbers');

    /**
     * @var array
     */
    protected static $defaultEntitiesExcluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getDojang($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /* @var \App\Entity\Dojang $entity */
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
    public function getDojangs($criteria = array())
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
     * @param $desc
     * @return array
     */
    public function createDojang($name, $desc)
    {
        /**
         * @var \App\Entity\Dojang $entity
         */
        $entityClass = '\\' . $this->entityPath;
        $entity = new $entityClass();
        $entity->setName($name);
        $entity->setDescription($desc);

        $this->persistAndFlush($entity);

        return self::formatData($entity);
    }

    /**
     * @param $id
     * @param $name
     * @param $desc
     * @return array
     */
    public function updateDojang($id, $name, $desc)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /**
         * @var \App\Entity\Dojang $entity
         */
        $entity = $repository->find($id);

        if ($entity === null) {
            return null;
        }

        $entity->setName($name);
        $entity->setDescription($desc);
        $entity->setUpdated(new \DateTime());

        $this->persistAndFlush($entity);

        return self::formatData($entity);
    }

    public function deleteDojang($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityPath);
        /**
         * @var \App\Entity\Dojang $entity
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
     * @param \App\Entity\Dojang $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true) {
        $formatted = array(
            'id' => $data->getId(),
            'name' => $data->getName(),
            'description' => $data->getDescription(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => self::formatLink($data, 'dojangs', 'self')
        );

        if($getRelations && self::isIncluded('dojangAddresses')) {
            $addresses = $data->getAddresses();
            if (!empty($addresses)) {
                foreach ($addresses as $address) {
                    $formatted['addresses'][] = $address;//Ranks::formatData($address, false);
                }
            }
        }

        if($getRelations && self::isIncluded('dojangEmailAddresses')) {
            $emailAddresses = $data->getEmailAddresses();
            if (!empty($emailAddresses)) {
                foreach ($emailAddresses as $emailAddress) {
                    $formatted['emailAddresses'][] = $emailAddress;//Ranks::formatData($address, false);
                }
            }
        }

        if($getRelations && self::isIncluded('dojangPhoneNumbers')) {
            $phoneNumbers = $data->getPhoneNumbers();
            if (!empty($phoneNumbers)) {
                foreach ($phoneNumbers as $phoneNumber) {
                    $formatted['phoneNumbers'][] = $phoneNumber;//Ranks::formatData($address, false);
                }
            }
        }

        return $formatted;
    }
}
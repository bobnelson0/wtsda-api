<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-02-20
 * Time: 1:56 PM
 */
namespace App\Service;

use App\Service;
use App\Util\Entity;

/**
 * Class DojangEmailAddresses
 * @package App\Service
 */
class DojangPhoneNumbers extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\DojangPhoneNumber';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'doj_ph';

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
    protected $defaultSorts = array(array('sort' => 'id', 'dir' => 'asc'));

    /**
     * @var array
     */
    protected static $defaultEntitiesIncluded = array();

    /**
     * @param $id
     * @return array
     */
    public function getDojangPhoneNumber($id)
    {
        /* @var \App\Entity\DojangPhoneNumber $entity */
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
    public function getDojangPhoneNumbers($criteria = array())
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
     * @param \App\Entity\DojangPhoneNumber $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true) {
        $formatted = array(
            'id' => $data->getId(),
            'type' => $data->getType(),
            'phoneNumber' => $data->getNumber(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => static::formatLink($data, 'dojangPhoneNumbers', static::LINK_RELATION_SELF),
            'relations' => array('dojang')
        );

        if($getRelations && static::isIncluded('dojang')) {
            $dojang = $data->getDojang();
            $formatted['dojang'] = Dojangs::formatData($dojang, false);
        }

        return $formatted;
    }
}
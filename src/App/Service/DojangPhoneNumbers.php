<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-02-20
 * Time: 1:56 PM
 */

namespace App\Service;

use App\Service;
use App\Util\Request;

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
            'links' => self::formatLink($data, 'dojangPhoneNumbers', self::LINK_RELATION_SELF)
        );

        return $formatted;
    }
}
<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-02-20
 * Time: 1:39 PM
 */
namespace App\Service;

use App\Service;
use App\Util\Request;

/**
 * Class DojangAddresses
 * @package App\Service
 */
class DojangAddresses extends Service
{
    /**
     * Entity path
     *
     * $var string
     */
    protected $entityPath = 'App\Entity\DojangAddress';

    /**
     * Entity alias
     *
     * $var string
     */
    protected $entityAlias = 'doj_ad';

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
    protected static $defaultEntitiesIncluded = array('dojang');

    /**
     * @param \App\Entity\DojangAddress $data
     * @param $getRelations
     * @return array
     */
    public static function formatData($data, $getRelations = true) {
        $formatted = array(
            'id' => $data->getId(),
            'formatted' => $data->getFormatted(),
            'created' => $data->getCreated(),
            'updated' => $data->getUpdated(),
            'links' => self::formatLink($data, 'dojangAddresses', 'self')
        );

        return $formatted;
    }
}
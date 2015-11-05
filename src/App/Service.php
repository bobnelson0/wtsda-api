<?php

namespace App;

use Slim\Slim;

abstract class Service
{
    const LINK_RELATION_SELF = 'self';
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

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

    /**
     * @param $key
     * @return bool
     */
    public static function isIncluded($key) {
        //TODO Fix/Test me
        $request = Slim::getInstance()->request();
        $include = $request->params('incl');

        if(empty($include)) {
            $include = static::$defaultEntitiesIncluded;
        } else {
            $include = explode(',', $include);
        }

        if(in_array($key, $include)) {
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
    public static function formatLink($data, $entity, $relation) {
        $rootUri = Slim::getInstance()->request()->getRootUri();
        $id = $data->getId();

        return array(
            'rel' => $relation,
            'href' => "$rootUri/$entity/$id"
        );
    }
}
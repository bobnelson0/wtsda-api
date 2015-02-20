<?php

namespace App;

use Slim\Slim;

abstract class Service
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    protected static $defaultEntitiesIncluded = array();

    /**
     * @var array
     */
    protected static $defaultEntitiesExcluded = array();

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
        //TODO Test me
        $request = Slim::getInstance()->request();
        $include = $request->params('incl');
        $exclude = $request->params('excl');

        if(empty($include)) {
            $include = self::$defaultEntitiesIncluded;
        }

        if(empty($exclude)) {
            $exclude = self::$defaultEntitiesExcluded;
        }

        if(in_array($key, $include)) {
            return true;
        }

        if(in_array($key, $exclude)) {
            return false;
        }
        return true;
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
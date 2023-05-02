<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-06
 * Time: 2:47 PM
 */

namespace App\Util;


class Entity {

    public static function findById($entityManager, $entity, $id) {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entity = $entityManager->getRepository($entity)->find($id);
        return $entity;
    }
}
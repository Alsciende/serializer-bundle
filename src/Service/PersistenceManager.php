<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 22/01/18
 * Time: 13:37
 */

namespace Alsciende\SerializerBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 */
class PersistenceManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct (EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find the managed version of an entity
     *
     * @param string $className
     * @param object $entity
     * @return object
     */
    public function findManaged ($className, $entity)
    {
        $obj = $this->entityManager->find(
            $className,
            $this->entityManager->getClassMetadata($className)->getIdentifierValues($entity)
        );

        $this->entityManager->initializeObject($obj);

        return $obj;
    }
}

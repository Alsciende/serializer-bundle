<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Model\Source;
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
     * @param object $entity
     * @return object
     */
    public function findManaged ($entity)
    {
        $classMetadata = $this->entityManager->getClassMetadata(get_class($entity));
        $className = $classMetadata->name;
        $id = $classMetadata->getIdentifierValues($entity);

        $obj = $this->entityManager->find($className, $id);

        if($obj instanceof $className) {
            $this->entityManager->initializeObject($obj);
        } else {
            $obj = new $className;
            $classMetadata->setIdentifierValues($obj, $id);
            $this->entityManager->persist($obj);
        }

        return $obj;
    }

    /**
     * @param Source $source
     */
    public function warmup(Source $source)
    {
        $this->entityManager->getRepository($source->getClassName())->findAll();
    }

    /**
     *
     */
    public function commit()
    {
        $this->entityManager->flush();
    }
}

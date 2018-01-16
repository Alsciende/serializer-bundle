<?php

namespace Alsciende\SerializerBundle\Metadata;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of AbstractAdapter
 *
 * @author Alsciende <alsciende@icloud.com>
 */
abstract class AbstractAdapter
{
    /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
    private $entityManager;

    protected function __construct (EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata[]
     */
    protected function getAllMetadata ()
    {
        return $this->entityManager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * @param string $className
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected function getMetadataFor ($className)
    {
        return $this->entityManager->getClassMetadata($className);
    }
}
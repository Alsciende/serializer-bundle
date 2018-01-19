<?php

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Metadata\AbstractAdapter;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of Adapter
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class MetadataService extends AbstractAdapter
{
    public function __construct (EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * Returns a list of all classes
     *
     * @return string[]
     */
    public function getAllManagedClassNames ()
    {
        $result = [];
        $allMetadata = $this->getAllMetadata();
        foreach ($allMetadata as $metadata) {
            $result[] = $metadata->getName();
        }

        return $result;
    }

    /**
     * Returns an array of foreign key => foreign entity class
     * for all classes that this class depends on
     *
     * @param string $className
     * @return string[]
     */
    public function getAllTargetClasses ($className)
    {
        $result = [];

        $classMetadata = $this->getMetadataFor($className);
        foreach ($classMetadata->getAssociationMappings() as $mapping) {
            if ($mapping['isOwningSide']) {
                $result[$mapping['fieldName']] = $mapping['targetEntity'];
            }
        }

        return $result;
    }

    public function getColumnName ($className, $fieldName)
    {
        $classMetadata = $this->getMetadataFor($className);
        return $classMetadata->getColumnName($fieldName);
    }
}
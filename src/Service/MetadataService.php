<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory;

/**
 * Description of Adapter
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class MetadataService
{
    private $metadataFactory;

    public function __construct (ClassMetadataFactory $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
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
    public function getAllTargetClasses (string $className)
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

    /**
     * @param string $className
     * @param string $fieldName
     * @return string
     */
    public function getColumnName (string $className, string $fieldName)
    {
        $classMetadata = $this->getMetadataFor($className);

        return $classMetadata->getColumnName($fieldName);
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @return array
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function getAssociationMapping (string $className, string $fieldName)
    {
        $classMetadata = $this->getMetadataFor($className);

        return $classMetadata->getAssociationMapping($fieldName);
    }

    /**
     * @param string $className
     * @param array  $data
     * @return object
     */
    public function hydrate (string $className, array $data)
    {
        $entity = new $className;
        $classMetadata = $this->getMetadataFor($className);
        foreach ($data as $field => $value) {
            $classMetadata->setFieldValue($entity, $field, $value);
        }

        return $entity;
    }

    /**
     * @param string $className
     * @param object $entity
     * @param string $fieldName
     * @return mixed
     */
    public function getFieldValue (string $className, $entity, string $fieldName)
    {
        return $this->getMetadataFor($className)->getFieldValue($entity, $fieldName);
    }

    /**
     * @param string $className
     * @param object $entity
     * @param string $fieldName
     * @param mixed  $value
     * @return void
     */
    public function setFieldValue (string $className, $entity, string $fieldName, $value)
    {
        $this->getMetadataFor($className)->setFieldValue($entity, $fieldName, $value);
    }

    /**
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata[]
     */
    private function getAllMetadata ()
    {
        return $this->metadataFactory->getAllMetadata();
    }

    /**
     * @param string $className
     * @return ClassMetadata
     */
    private function getMetadataFor (string $className)
    {
        $metadata = $this->metadataFactory->getMetadataFor($className);
        if ($metadata instanceof ClassMetadata) {
            return $metadata;
        }

        throw new \LogicException('Doctrine MetadataFactory->getMetadataFor should return \Doctrine\ORM\Mapping\ClassMetadata objects.');
    }
}
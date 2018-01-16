<?php

namespace Alsciende\SerializerBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of ObjectManager
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ObjectManager
{
    /* @var \Doctrine\ORM\EntityManager $entityManager */
    private $entityManager;

    function __construct (EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find the entity referenced by the identifiers in $data, or create a new one with the correct identifiers
     *
     * @param array $data
     * @param string $className
     * @return object
     */
    function findOrCreateObject ($data, $className)
    {
        $identifiers = $this->getIdentifierValues($data, $className);

        $entity = $this->findObject($identifiers, $className);

        if (isset($entity)) {
            return $entity;
        }

        $entity = new $className();
        $this->updateObject($entity, $identifiers);

        return $entity;
    }

    /**
     * Return the reference corresponding to the assocation in the entity
     *
     * @param string $targetClass
     * @param string $associationKey
     * @param object|null $associationValue
     * @return array
     */
    function getReferenceFromAssociation ($targetClass, $associationKey, $associationValue)
    {
        $targetIdentifier = $this->getSingleIdentifier($targetClass);
        $referenceValue = null;
        if ($associationValue !== null) {
            $referenceValue = $this->readObject($associationValue, $targetIdentifier);
        }
        $referenceKey = $associationKey . '_' . $targetIdentifier;

        return [$referenceKey, $referenceValue];
    }

    /**
     * Returns the single identifier of a class. Throws an exception if the class
     * using a composite key
     *
     * @param string $className
     * @return string
     */
    function getSingleIdentifier ($className)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);
        $identifierFieldNames = $classMetadata->getIdentifierFieldNames();
        if (count($identifierFieldNames) > 1) {
            throw new \InvalidArgumentException('Too many identifiers for ' . $classMetadata->getName());
        }

        return $identifierFieldNames[0];
    }

    /**
     * Updates some fields in the entity
     *
     * @param object $entity
     * @param array $data
     * @return object
     */
    function updateObject ($entity, $data)
    {
        $className = $this->getClassName($entity);
        $classMetadata = $this->entityManager->getClassMetadata($className);
        foreach ($data as $field => $value) {
            $classMetadata->setFieldValue($entity, $field, $value);
        }

        return $entity;
    }

    /**
     * Return a managed entity
     *
     * @param object $entity
     * @return object
     */
    function mergeObject ($entity)
    {
        return $this->entityManager->merge($entity);
    }

    function getFieldValue ($data, $className, $fieldName)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);
        $columnName = $classMetadata->getColumnName($fieldName);

        return $data[$columnName];
    }

    function setFieldValue (&$result, $className, $fieldName, $value)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);
        $columnName = $classMetadata->getColumnName($fieldName);
        $result[$columnName] = $value;
    }

    function getAssociationValue ($data, $className, $fieldName)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);
        $associationMapping = $classMetadata->getAssociationMapping($fieldName);
        $association = $this->findAssociation($data, $associationMapping);
        if ($association) {
            return $association['associationValue'];
        }

        throw new \RuntimeException('No such field.');
    }

    function setAssociationValue (&$result, $className, $fieldName, $value)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);
        $associationMapping = $classMetadata->getAssociationMapping($fieldName);
        list($referenceKey, $referenceValue) = $this->getReferenceFromAssociation($associationMapping['targetEntity'], $fieldName, $value);
        $result[$referenceKey] = $referenceValue;
    }

    /**
     * Returns the value of a field of the entity
     *
     * @param object $entity
     * @param string $field
     * @return mixed
     */
    function readObject ($entity, $field)
    {
        $className = $this->getClassName($entity);
        $classMetadata = $this->entityManager->getClassMetadata($className);

        return $classMetadata->getFieldValue($entity, $field);
    }

    /**
     * Find the entity referenced by the identifiers in $data
     *
     * @param array $identifiers
     * @param string $className
     * @return object|null
     */
    function findObject ($identifiers, $className)
    {
        return $this->entityManager->find($className, $identifiers);
    }

    /**
     * Returns the array of identifier keys/values that can be used with find()
     * to find the entity described by $incoming
     *
     * If an identifier is a foreignIdentifier, find the foreign entity
     *
     * @param array $data
     * @param string $className
     * @return array
     */
    function getIdentifierValues ($data, $className)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);

        $result = [];
        foreach ($classMetadata->getIdentifierFieldNames() as $identifierFieldName) {
            $result[$identifierFieldName] = $this->getIdentifierValue($data, $className, $identifierFieldName);
        }

        return $result;
    }

    /**
     * Returns the unique value (scalar or object) used as identifier in $data
     * considered as a normalization of $className
     *
     * @param array $data
     * @param string $className
     * @param string $identifierFieldName
     * @return mixed
     * @throws \InvalidArgumentException
     */
    private function getIdentifierValue ($data, $className, $identifierFieldName)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);

        if (in_array($identifierFieldName, $classMetadata->getFieldNames())) {
            if (!isset($data[$identifierFieldName])) {
                throw new \InvalidArgumentException("Missing identifier for entity " . $className . " in data " . json_encode($data));
            }

            return $data[$identifierFieldName];
        } else {
            $associationMapping = $classMetadata->getAssociationMapping($identifierFieldName);
            $association = $this->findAssociation($data, $associationMapping);
            if (!$association || !isset($association['associationValue'])) {
                throw new \InvalidArgumentException("Cannot find entity referenced by $identifierFieldName in data " . json_encode($data));
            }

            return $association['associationValue'];
        }
    }

    /**
     * Finds all the foreign keys in $data and the entity associated
     *
     * eg ["article_id" => 2134] returns
     * array([ "associationKey" => "article", "associationValue" => (object Article), "referenceKeys" => [ "article_id"] ])
     *
     * @param array $data
     * @return array
     */
    function findAssociations ($data, $className)
    {
        $classMetadata = $this->entityManager->getClassMetadata($className);

        $associations = [];
        foreach ($classMetadata->getAssociationMappings() as $mapping) {
            $association = $this->findAssociation($data, $mapping);
            if ($association) {
                $associations[] = $association;
            }
        }

        return $associations;
    }

    /**
     * Returns a description of the association, including the foreign key value
     * as found in $data
     *
     * @param array $data an array where the value of the foreign key can be found
     * @param array $associationMapping
     * @return array|null
     */
    private function findAssociation ($data, $associationMapping)
    {
        if (!$associationMapping['isOwningSide']) {
            return null;
        }
        $referenceKeys = [];
        $referenceValues = [];
        foreach ($associationMapping['sourceToTargetKeyColumns'] as $referenceKey => $targetIdentifier) {
            if (!key_exists($referenceKey, $data)) {
                return null;
            }
            $referenceKeys[] = $referenceKey;
            $referenceValues[$targetIdentifier] = $data[$referenceKey];
        }
        $id = array_filter($referenceValues);
        if (empty($id)) {
            return null;
        }
        $associationValue = $this->entityManager->getRepository($associationMapping['targetEntity'])->find($id);

        return [
            'referenceKeys'    => $referenceKeys,
            'associationKey'   => $associationMapping['fieldName'],
            'associationValue' => $associationValue,
        ];
    }

    /**
     * Returns the class name of an entity, even if the object is a Proxy
     * @param object $entity
     * @return string
     */
    function getClassName ($entity)
    {
        return $this->entityManager->getClassMetadata(get_class($entity))->rootEntityName;
    }
}

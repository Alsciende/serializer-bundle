<?php

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Manager\ObjectManager;

/**
 * Turns an object into an array
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class NormalizingService
{

    public function __construct (ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     *
     * @var \Alsciende\SerializerBundle\Manager\ObjectManager
     */
    private $objectManager;

    /**
     *
     * @param object $entity
     * @param array $propertyMap
     * @return array
     */
    public function toArray ($entity, $propertyMap)
    {
        $result = [];

        foreach ($propertyMap as $property => $type) {
            $result[$property] = $this->objectManager->readObject($entity, $property);
        }

        return $result;
    }

    /**
     * with [ "id" => 3, "name" => "The Dark Side of the Moon", "releasedAt" => (DateTime), "band" => (Band) ]
     * does [ "id" => 3, "name" => "The Dark Side of the Moon", "released_at" => "1973-03-01", "band_code" => "pink-floyd" ]
     *
     * @param array $data
     * @param string $className
     * @param array $propertyMap
     * @return array
     */
    public function normalize ($data, $className, $propertyMap)
    {
        $result = [];

        foreach ($propertyMap as $property => $type) {
            $value = $data[$property];
            if ($value === null) {
                $this->objectManager->setFieldValue($result, $className, $property, null);
                continue;
            }
            switch ($type) {
                case 'string':
                    $this->objectManager->setFieldValue($result, $className, $property, $value);
                    break;
                case 'integer':
                    $this->objectManager->setFieldValue($result, $className, $property, $value);
                    break;
                case 'boolean':
                    $this->objectManager->setFieldValue($result, $className, $property, $value);
                    break;
                case 'date':
                    $value = $value->format('Y-m-d');
                    $this->objectManager->setFieldValue($result, $className, $property, $value);
                    break;
                case 'array':
                    $this->objectManager->setFieldValue($result, $className, $property, $value);
                    break;
                case 'association':
                    $this->objectManager->setAssociationValue($result, $className, $property, $value);
                    break;
                default:
                    throw new \Exception("Unknown type: $type");
            }
        }

        return $result;
    }

    /**
     * with [ "id" => 3, "name" => "The Dark Side of the Moon", "released_at" => "1973-03-01", "band_code" => "pink-floyd" ]
     * does [ "id" => 3, "name" => "The Dark Side of the Moon", "releasedAt" => (DateTime), "band" => (Band) ]
     *
     * @param array $data
     * @param string $className
     * @param array $propertyMap
     * @return array
     */
    public function denormalize ($data, $className, $propertyMap)
    {
        $result = [];

        foreach ($propertyMap as $property => $type) {
            switch ($type) {
                case 'string':
                    $value = $this->objectManager->getFieldValue($data, $className, $property);
                    $result[$property] = $value;
                    break;
                case 'integer':
                    $value = $this->objectManager->getFieldValue($data, $className, $property);
                    $result[$property] = isset($value) ? (integer) $value : null;
                    break;
                case 'boolean':
                    $value = $this->objectManager->getFieldValue($data, $className, $property);
                    $result[$property] = isset($value) ? (boolean) $value : null;
                    break;
                case 'array':
                    $value = $this->objectManager->getFieldValue($data, $className, $property);
                    $result[$property] = $value;
                    break;
                case 'date':
                    $value = $this->objectManager->getFieldValue($data, $className, $property);
                    $result[$property] = $value ? \DateTime::createFromFormat('Y-m-d', $value) : null;
                    break;
                case 'association':
                    $value = $this->objectManager->getAssociationValue($data, $className, $property);
                    $result[$property] = $value;
                    break;
                default:
                    throw new \Exception("Unknown type: $type");
            }
        }

        return $result;
    }

}

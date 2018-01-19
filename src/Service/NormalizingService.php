<?php

namespace Alsciende\SerializerBundle\Service;


/**
 *
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class NormalizingService
{
    /** @var ObjectManager $objectManager */
    private $objectManager;

    public function __construct (ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
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

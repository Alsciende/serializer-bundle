<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 22/01/18
 * Time: 11:44
 */

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Exception\UnknownTypeException;
use Alsciende\SerializerBundle\Model\Fragment;
use Psr\Log\LoggerInterface;

/**
 */
class MergingService
{
    /** @var LoggerInterface $logger */
    private $logger;

    /** @var MetadataService $metadata */
    private $metadata;

    /** @var NormalizerManager $normalizer */
    private $normalizer;

    public function __construct (
        MetadataService $metadata,
        NormalizerManager $normalizer
    )
    {
        $this->metadata = $metadata;
        $this->normalizer = $normalizer;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger (LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param Fragment $fragment
     * @return null|object
     * @throws UnknownTypeException
     */
    public function merge (Fragment $fragment)
    {
        $className = $fragment->getBlock()->getSource()->getClassName();

        $entity = $this->metadata->findManaged($className, $fragment->getEntity());

        $modifiedProperties = $this->filterModifiedProperties(
            $className,
            $entity,
            $fragment->getNormalizedData(),
            $fragment->getBlock()->getSource()->getProperties()
        );

        if(count($modifiedProperties)) {
            $this->logger->notice(sprintf('Data change from [%s]', $fragment->getBlock()->getPath()), $modifiedProperties);

            foreach ($modifiedProperties as $field => $value) {
                $this->metadata->setFieldValue($className, $entity, $field, $value);
            }
        }

        return $entity;
    }

    /**
     * @param string $className
     * @param object $entity
     * @param array $data
     * @param array $propertyMap
     * @return array
     * @throws UnknownTypeException
     */
    private function filterModifiedProperties($className, $entity, $data, $propertyMap)
    {
        foreach($propertyMap as $property => $type) {
            if($this->normalizer->getNormalizer($type)->isEqual(
                $data[$property],
                $this->metadata->getFieldValue($className, $entity, $property)
            )) {
                unset($data[$property]);
            }
        }

        return $data;
    }
}

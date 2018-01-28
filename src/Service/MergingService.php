<?php
declare(strict_types=1);

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

    /** @var NormalizerService $normalizer */
    private $normalizer;

    public function __construct (
        MetadataService $metadata,
        NormalizerService $normalizer
    ) {
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
     * @param object $entity
     * @param Fragment $fragment
     * @return object
     * @throws UnknownTypeException
     */
    public function merge ($entity, Fragment $fragment)
    {
        $className = $fragment->getBlock()->getSource()->getClassName();

        $changeSet = $this->getChangeSet(
            $className,
            $entity,
            $fragment->getNormalizedData(),
            $fragment->getBlock()->getSource()->getProperties()
        );

        if (count($changeSet)) {
            if ($this->logger instanceof LoggerInterface) {
                $this->logger->notice(sprintf('Data change from [%s]', $fragment->getBlock()->getPath()), $changeSet);
            }

            foreach ($changeSet as $field => $value) {
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
    private function getChangeSet (string $className, $entity, array $data, array $propertyMap): array
    {
        foreach ($propertyMap as $property => $config) {
            if ($this->normalizer->getNormalizer($config->type)->isEqual(
                $data[$property],
                $this->metadata->getFieldValue($className, $entity, $property)
            )) {
                unset($data[$property]);
            }
        }

        return $data;
    }
}

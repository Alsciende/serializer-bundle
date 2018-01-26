<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;
use Alsciende\SerializerBundle\Model\Fragment;

/**
 * Class HydrationService
 */
class HydrationService
{
    /** @var MetadataService $metadata */
    private $metadata;

    public function __construct (MetadataService $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param Fragment $fragment
     * @return Fragment
     */
    public function hydrate (Fragment $fragment): Fragment
    {
        return $fragment->setHydratedEntity($this->getHydratedEntity(
            $fragment->getBlock()->getSource()->getClassName(),
            $fragment->getNormalizedData()
        ));
    }

    /**
     * @param string $className
     * @param array  $data
     * @return object
     */
    public function getHydratedEntity (string $className, array $data)
    {
        $entity = new $className;
        foreach ($data as $field => $value) {
            $this->metadata->setFieldValue($className, $entity, $field, $value);
        }

        return $entity;
    }
}
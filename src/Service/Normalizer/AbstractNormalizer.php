<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Exception\MissingPropertyException;
use Alsciende\SerializerBundle\Service\MetadataService;

/**
 */
abstract class AbstractNormalizer
{
    /**
     * @var MetadataService $metadata
     */
    protected $metadata;

    public function __construct(MetadataService $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @param Field $config
     * @return mixed
     * @throws MissingPropertyException
     */
    protected function getRawValue(string $className, string $fieldName, array $data, Field $config)
    {
        $columnName = $this->metadata->getColumnName($className, $fieldName);

        if (!key_exists($columnName, $data)) {
            if ($config->mandatory === false) {
                return $config->default;
            }

            throw new MissingPropertyException($data, $columnName);
        }

        return $data[$columnName];
    }
}

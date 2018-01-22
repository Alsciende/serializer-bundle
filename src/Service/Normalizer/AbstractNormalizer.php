<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 19/01/18
 * Time: 16:16
 */

namespace Alsciende\SerializerBundle\Service\Normalizer;

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

    public function __construct (MetadataService $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array  $data
     * @return mixed
     * @throws MissingPropertyException
     */
    protected function getRawValue ($className, $fieldName, $data)
    {
        $columnName = $this->metadata->getColumnName($className, $fieldName);

        if (!key_exists($columnName, $data)) {
            throw new MissingPropertyException($data, $columnName);
        }

        return $data[$columnName];
    }
}

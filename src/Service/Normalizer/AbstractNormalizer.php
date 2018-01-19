<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 19/01/18
 * Time: 16:16
 */

namespace Alsciende\SerializerBundle\Service\Normalizer;
use Alsciende\SerializerBundle\Service\MetadataService;

/**
 */
class AbstractNormalizer
{
    /**
     * @var MetadataService $metadata
     */
    protected $metadata;

    public function __construct (MetadataService $metadata)
    {
        $this->metadata = $metadata;
    }
}

<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Model;

/**
 * Represents a data fragment, a record to be serialized/deserialized
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Fragment
{
    /**
     * @var Block
     */
    private $block;

    /**
     * @var array
     */
    private $rawData;

    /**
     * @var array
     */
    private $normalizedData;

    /**
     * @var object
     */
    private $hydratedEntity;

    public function __construct (Block $block, array $data)
    {
        $this->block = $block;
        $this->rawData = $data;
    }

    /**
     *
     * @return array
     */
    public function getRawData (): array
    {
        return $this->rawData;
    }

    /**
     *
     * @return Block
     */
    public function getBlock (): Block
    {
        return $this->block;
    }

    /**
     * @return object
     */
    public function getHydratedEntity ()
    {
        return $this->hydratedEntity;
    }

    /**
     * @param object $hydratedEntity
     *
     * @return $this
     */
    public function setHydratedEntity ($hydratedEntity): self
    {
        $this->hydratedEntity = $hydratedEntity;

        return $this;
    }

    /**
     * @return array
     */
    public function getNormalizedData (): array
    {
        return $this->normalizedData;
    }

    /**
     * @param array $normalizedData
     *
     * @return $this
     */
    public function setNormalizedData ($normalizedData): self
    {
        $this->normalizedData = $normalizedData;

        return $this;
    }
}

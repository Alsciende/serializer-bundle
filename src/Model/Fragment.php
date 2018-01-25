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
     * @var array
     */
    private $data;

    /**
     * @var Block
     */
    private $block;

    /**
     * @var array
     */
    private $normalizedData;

    /**
     * @var object
     */
    private $entity;

    public function __construct (Block $block, array $data)
    {
        $this->block = $block;
        $this->data = $data;
    }

    /**
     *
     * @return array
     */
    public function getData (): array
    {
        return $this->data;
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
    public function getEntity ()
    {
        return $this->entity;
    }

    /**
     * @param object $entity
     *
     * @return $this
     */
    public function setEntity ($entity): self
    {
        $this->entity = $entity;

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

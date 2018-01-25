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
    public function getData ()
    {
        return $this->data;
    }

    /**
     *
     * @return Block
     */
    public function getBlock ()
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
    public function setEntity ($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return array
     */
    public function getNormalizedData ()
    {
        return $this->normalizedData;
    }

    /**
     * @param array $normalizedData
     *
     * @return $this
     */
    public function setNormalizedData ($normalizedData)
    {
        $this->normalizedData = $normalizedData;

        return $this;
    }
}

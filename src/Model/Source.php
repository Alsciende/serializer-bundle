<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Model;

/**
 * Represents a data source, a table to be serialized/deserialized
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Source
{

    /** @var string|null $break */
    private $break;

    /** @var string $className */
    private $className;

    /** @var array $properties */
    private $properties;

    /** @var Block[] $blocks */
    private $blocks;

    public function __construct ($className, $break = null)
    {
        $this->className = $className;
        $this->break = $break;
        $this->properties = [];
        $this->blocks = [];
    }

    /**
     *
     * @return string|null
     */
    public function getBreak ()
    {
        return $this->break;
    }

    /**
     * @return bool
     */
    public function hasBreak ()
    {
        return isset($this->break);
    }

    /**
     *
     * @return string
     */
    function getClassName ()
    {
        return $this->className;
    }

    /**
     * Get properties
     *
     * @return array
     */
    public function getProperties ()
    {
        return $this->properties;
    }

    /**
     * Add a property
     *
     * @param string $name
     * @param string $type
     * @return $this
     */
    public function addProperty ($name, $type)
    {
        $this->properties[$name] = $type;

        return $this;
    }

    /**
     * @return Block[]
     */
    public function getBlocks ()
    {
        return $this->blocks;
    }

    /**
     * @param Block $block
     * @return $this
     */
    public function addBlock (Block $block)
    {
        $this->blocks[] = $block;
        $block->setSource($this);

        return $this;
    }
}

<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Model;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;

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

    public function __construct (string $className, string $break = null)
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
    public function hasBreak (): bool
    {
        return isset($this->break);
    }

    /**
     *
     * @return string
     */
    function getClassName (): string
    {
        return $this->className;
    }

    /**
     * Get properties
     *
     * @return array
     */
    public function getProperties (): array
    {
        return $this->properties;
    }

    /**
     * Add a property
     *
     * @param string $name
     * @param Field $config
     * @return $this
     */
    public function addProperty ($name, Field $config): self
    {
        $this->properties[$name] = $config;

        return $this;
    }

    /**
     * @return Block[]
     */
    public function getBlocks (): array
    {
        return $this->blocks;
    }

    /**
     * @param Block $block
     * @return $this
     */
    public function addBlock (Block $block): self
    {
        $this->blocks[] = $block;
        $block->setSource($this);

        return $this;
    }
}

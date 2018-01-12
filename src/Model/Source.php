<?php

namespace Alsciende\SerializerBundle\Model;

/**
 * Represents a data source, a table to be serialized/deserialized
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Source
{

    /* @var string */
    private $break;

    /* @var string */
    private $path;

    /* @var string */
    private $className;

    /* @var array */
    private $properties;

    function __construct ($className, $path, $break = null)
    {
        $this->className = $className;
        $this->path = $path;
        $this->break = $break;
        $this->properties = [];
    }

    /**
     *
     * @return string|null
     */
    function getBreak ()
    {
        return $this->break;
    }

    /**
     *
     * @return string|null
     */
    function getPath ()
    {
        return $this->path;
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
     *
     * @param string $break
     * @return self
     */
    function setBreak ($break)
    {
        $this->break = $break;

        return $this;
    }

    /**
     *
     * @param string $path
     * @return self
     */
    function setPath ($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     *
     * @param string $className
     * @return self
     */
    function setClassName ($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get properties
     *
     * @return array
     */
    function getProperties ()
    {
        return $this->properties;
    }

    /**
     * Add a property
     *
     * @param string $name
     * @param string $type
     * @return self
     */
    function addProperty ($name, $type)
    {
        $this->properties[$name] = $type;

        return $this;
    }

}

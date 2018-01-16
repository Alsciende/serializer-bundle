<?php

namespace Alsciende\SerializerBundle\Model;

/**
 * Represents a data source, a table to be serialized/deserialized
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Source
{

    /* @var string|null */
    private $break;

    /* @var string|null */
    private $path;

    /* @var string */
    private $className;

    /* @var array */
    private $properties;

    function __construct ($className, $path = null, $break = null)
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

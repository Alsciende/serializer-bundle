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

    /* @var string */
    private $className;

    /* @var array */
    private $properties;

    function __construct ($className, $break = null)
    {
        $this->className = $className;
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

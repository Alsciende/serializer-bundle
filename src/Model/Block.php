<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Model;

/**
 * Represents a data block: some encoded text at a path,
 *      representing one or more objects of the same class,
 *      that must be decoded as a list of Fragments
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Block
{
    /**
     * @var Source
     */
    private $source;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $data;

    /**
     *
     * @param string      $data
     * @param string|null $path
     */
    public function __construct ($data, $path = null)
    {
        $this->data = $data;
        if (isset($path)) {
            $this->path = realpath($path);
            $this->name = pathinfo($path, PATHINFO_FILENAME);
        }
    }

    /**
     *
     * @return Source
     */
    public function getSource ()
    {
        return $this->source;
    }

    /**
     *
     * @return string|null
     */
    public function getPath ()
    {
        return $this->path;
    }

    /**
     *
     * @return string
     */
    public function getData ()
    {
        return $this->data;
    }

    /**
     *
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     *
     * @param Source $source
     * @return $this
     */
    public function setSource (Source $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     *
     * @param string $name
     * @return $this
     */
    public function setName ($name)
    {
        $this->name = $name;

        return $this;
    }
}

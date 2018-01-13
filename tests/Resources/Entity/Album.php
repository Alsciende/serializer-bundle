<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 11/01/18
 * Time: 13:53
 */

namespace Alsciende\SerializerBundle\Test\Resources\Entity;

/**
 */
class Album
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Artist */
    private $artist;

    /** @var Label */
    private $label;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId ($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName ($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist ()
    {
        return $this->artist;
    }

    /**
     * @param $artist
     * @return $this
     */
    public function setArtist ($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Label
     */
    public function getLabel ()
    {
        return $this->label;
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel ($label)
    {
        $this->label = $label;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 11/01/18
 * Time: 13:53
 */

namespace Alsciende\SerializerBundle\Test\Resources\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;

/**
 * @Skizzle(break="artist_id")
 */
class Album
{
    /**
     * @var string
     *
     * @Skizzle\Field(type="string")
     */
    private $id;

    /**
     * @var string
     *
     * @Skizzle\Field(type="string")
     */
    private $name;

    /**
     * @var Artist
     *
     * @Skizzle\Field(type="association")
     */
    private $artist;

    /**
     * @var Label
     *
     * @Skizzle\Field(type="association")
     */
    private $label;

    /**
     * @return string
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param string $id
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
     * @param string $name
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

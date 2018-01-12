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

    public function getId (): int
    {
        return $this->id;
    }

    public function setId (int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName (): string
    {
        return $this->name;
    }

    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArtist (): Artist
    {
        return $this->artist;
    }

    public function setArtist (Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getLabel (): Label
    {
        return $this->label;
    }

    public function setLabel (Label $label): self
    {
        $this->label = $label;

        return $this;
    }
}

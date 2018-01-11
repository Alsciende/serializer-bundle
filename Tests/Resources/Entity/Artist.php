<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 11/01/18
 * Time: 13:52
 */

namespace Tests\Resources\Entity;

/**
 */
class Artist
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /**
     * @return int
     */
    public function getId (): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId (int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }
}

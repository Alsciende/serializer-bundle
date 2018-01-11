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
class Label
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

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
}

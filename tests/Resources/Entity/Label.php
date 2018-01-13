<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 11/01/18
 * Time: 13:52
 */

namespace Alsciende\SerializerBundle\Test\Resources\Entity;

/**
 */
class Label
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

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
}

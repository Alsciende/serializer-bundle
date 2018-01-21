<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 11/01/18
 * Time: 13:52
 */

namespace Alsciende\SerializerBundle\Test\Resources\Entity;
use Alsciende\SerializerBundle\Annotation\Skizzle;

/**
 * @Skizzle()
 */
class Label
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
     * @var bool
     *
     * @Skizzle\Field(type="boolean")
     */
    private $active;

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
     * @return bool
     */
    public function isActive ()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive ($active)
    {
        $this->active = $active;

        return $this;
    }
}

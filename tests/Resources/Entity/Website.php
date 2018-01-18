<?php

namespace Alsciende\SerializerBundle\Test\Resources\Entity;

use Alsciende\SerializerBundle\Annotation\Skizzle;

/**
 * Description of Website
 *
 * @author Alsciende <alsciende@icloud.com>
 *
 * @Skizzle()
 */
class Website
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
}
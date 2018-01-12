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
class Artist
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
     * @var array
     *
     * @Skizzle\Field(type="array")
     */
    private $styles;

    /**
     * @var string
     *
     * @Skizzle\Field(type="string")
     */
    private $foundedIn;

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
     * @param string w$name
     * @return $this
     */
    public function setName ($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getStyles ()
    {
        return $this->styles;
    }

    /**
     * @param array $styles
     * @return $this
     */
    public function setStyles ($styles)
    {
        $this->styles = $styles;

        return $this;
    }

    /**
     * @return string
     */
    public function getFoundedIn ()
    {
        return $this->foundedIn;
    }

    /**
     * @param string $foundedIn
     * @return $this
     */
    public function setFoundedIn ($foundedIn)
    {
        $this->foundedIn = $foundedIn;

        return $this;
    }
}

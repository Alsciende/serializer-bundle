<?php

namespace Alsciende\SerializerBundle\Test\Resources\Entity;

/**
 * Description of Link
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Link
{
    /**
     * @var Artist
     */
    private $artist;

    /**
     * @var Website
     */
    private $website;

    /**
     * @var string
     */
    private $url;

    /**
     * @return Artist
     */
    public function getArtist ()
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     * @return $this
     */
    public function setArtist (Artist $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Website
     */
    public function getWebsite ()
    {
        return $this->website;
    }

    /**
     * @param Website $website
     * @return $this
     */
    public function setWebsite (Website $website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl ()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl ($url)
    {
        $this->url = $url;

        return $this;
    }
}
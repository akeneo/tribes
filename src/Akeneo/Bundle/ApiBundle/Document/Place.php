<?php

namespace Akeneo\Bundle\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 * @MongoDB\Index(keys={"location"="2d"})
 */
class Place
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @MongoDB\String
     */
    private $name;

    /**
     * @var Location
     *
     * @Assert\NotNull
     * @MongoDB\EmbedOne(targetDocument="Location")
     */
    private $location;

    /**
     * Place constructor.
     *
     * @param Location $location
     * @param string   $name
     */
    public function __construct(Location $location = null, $name = null)
    {
        $this->location = $location;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }
}

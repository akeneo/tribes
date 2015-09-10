<?php

namespace Akeneo\Bundle\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="subscriber")
 */
class Subscriber
{
    /**
     * @var string
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Location
     *
     * @Assert\NotNull
     * @MongoDB\EmbedOne(targetDocument="Location")
     */
    private $location;

    /**
     * @var string
     *
     * @Assert\Email
     * @MongoDB\String
     */
    private $email;

    /**
     * Subscriber constructor.
     *
     * @param Location $location
     * @param string   $email
     */
    public function __construct(Location $location = null, $email = null)
    {
        $this->location = $location;
        $this->email    = $email;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}

<?php

namespace Akeneo\Bundle\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 */
class User
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     * @MongoDB\String
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Email
     * @MongoDB\String
     */
    private $email;

    /**
     * @param string $name
     * @param string $email
     */
    public function __construct($name = null, $email = null)
    {
        $this->name  = $name;
        $this->email = $email;
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

    /**
     * @return boolean
     */
    public function getGroup()
    {
        if (preg_match('/.*@akeneo\.com$/', $this->email)) {
            return 'akeneo';
        }

        return 'community';
    }
}

<?php

namespace Akeneo\Bundle\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="event")
 */
class Event
{
    /**
     * @var string
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Url
     * @MongoDB\String
     */
    private $link;

    /**
     * @var Place
     *
     * @Assert\NotNull
     * @MongoDB\EmbedOne(targetDocument="Place")
     */
    private $place;

    /**
     * @var User
     *
     * @Assert\NotNull
     * @MongoDB\EmbedOne(targetDocument="User")
     */
    private $user;

    /**
     * @var array
     *
     * @Assert\NotNull
     * @MongoDB\Collection
     */
    private $tags = [];

    /**
     * @var \DateTime
     *
     * @Assert\NotNull
     * @MongoDB\Date
     */
    private $plannedAt;

    /**
     * @var \DateTime
     *
     * @MongoDB\Date
     */
    private $createdAt;

    /**
     * @param Place     $place
     * @param \DateTime $plannedAt
     * @param User      $user
     * @param array     $tags
     * @param string    $link
     */
    public function __construct(Place $place = null, \DateTime $plannedAt = null, User $user = null, array $tags = [], $link = null)
    {
        $this->place = $place;
        $this->plannedAt = $plannedAt;
        $this->user = $user;
        $this->tags = $tags;
        $this->link = $link;
        $this->createdAt = new \DateTime();
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
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param Place $place
     */
    public function setPlace(Place $place)
    {
        $this->place = $place;
    }

    /**
     * @return \DateTime
     */
    public function getPlannedAt()
    {
        return $this->plannedAt;
    }

    /**
     * @param \DateTime $plannedAt
     */
    public function setPlannedAt($plannedAt)
    {
        $this->plannedAt = $plannedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags = [])
    {
        $this->tags = $tags;
    }
}

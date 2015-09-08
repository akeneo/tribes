<?php

namespace Akeneo\Bundle\ApiBundle\DataFixtrues\MongoDB;

use Akeneo\Bundle\ApiBundle\Document\Location;
use Akeneo\Bundle\ApiBundle\Document\Place;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Akeneo\Bundle\ApiBundle\Document\Event;

class LoadEventData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $events = [
            new Event(
                new Place(new Location(37.4224764, -122.0842499), '1600 Amphitheatre Parkway, Mountain View, CA 94043, USA'),
                new \DateTime('now + 2 weeks'),
                'http://google.com'
            ),
        ];

        foreach ($events as $event) {
            $manager->persist($event);
        }

        $manager->flush();
    }
}

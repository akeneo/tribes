<?php

namespace Akeneo\Bundle\ApiBundle\DataFixtrues\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Akeneo\Bundle\ApiBundle\Document\Event;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $events = [
            new Event('http://google.com'),
        ];

        foreach ($events as $event) {
            $manager->persist($event);
        }

        $manager->flush();
    }
}
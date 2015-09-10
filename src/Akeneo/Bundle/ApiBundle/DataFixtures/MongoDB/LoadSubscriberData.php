<?php

namespace Akeneo\Bundle\ApiBundle\DataFixtrues\MongoDB;

use Akeneo\Bundle\ApiBundle\Document\Location;
use Akeneo\Bundle\ApiBundle\Document\Place;
use Akeneo\Bundle\ApiBundle\Document\Subscriber;
use Akeneo\Bundle\ApiBundle\Document\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Akeneo\Bundle\ApiBundle\Document\Event;

/**
 * Class LoadSubscriberData
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LoadSubscriberData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $events = [
            new Subscriber(new Location(37.4224764, -122.0842499), 'john.doe@google.com'),
            new Subscriber(new Location(47.21145800000001, -1.5415927000000238), 'janne.doe@akeneo.com'),
        ];

        foreach ($events as $event) {
            $manager->persist($event);
        }

        $manager->flush();
    }
}

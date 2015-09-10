<?php

namespace Akeneo\Bundle\ApiBundle\DataFixtrues\MongoDB;

use Akeneo\Bundle\ApiBundle\Document\Location;
use Akeneo\Bundle\ApiBundle\Document\Place;
use Akeneo\Bundle\ApiBundle\Document\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Akeneo\Bundle\ApiBundle\Document\Event;

/**
 * Class LoadEventData
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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
                new User('John Doe', 'john.doe@google.com'),
                ['silex', 'pim'],
                'https://www.google.com'
            ),
            new Event(
                new Place(new Location(47.21145800000001, -1.5415927000000238), '1 Quai Magellan, 44000 Nantes, France'),
                new \DateTime('now + 1 weeks'),
                new User('Janne Doe', 'janne.doe@akeneo.com'),
                ['akeneo', 'pim'],
                'http://www.akeneo.com'
            ),
            new Event(
                new Place(new Location(48.8898216, 2.2765125999999327), 'SensioLabs, Boulevard Victor Hugo, Clichy, France'),
                new \DateTime('now - 1 weeks'),
                new User('John Doe', 'john.doe@sensiolabs.com'),
                ['symfony', 'dam'],
                'http://sensiolabs.com/'
            ),
        ];

        foreach ($events as $event) {
            $manager->persist($event);
        }

        $manager->flush();
    }
}

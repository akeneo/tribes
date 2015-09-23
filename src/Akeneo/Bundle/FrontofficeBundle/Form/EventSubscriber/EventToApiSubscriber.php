<?php

namespace Akeneo\Bundle\FrontofficeBundle\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class EventToApiSubscriber
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventToApiSubscriber implements EventSubscriberInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::SUBMIT => 'submit'];
    }

    /**
     * @param FormEvent $event
     */
    public function submit(FormEvent $event)
    {
        $data = $event->getData();

        if (null === $data) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();

        $event->setData([
            'user'      => [
                'name'  => $user->getUsername(),
                'email' => $user->getEmail(),
            ],
            'tags'      => $data['tags'],
            'link'      => $data['link'],
            'plannedAt' => !empty($data['plannedAt']) ? $data['plannedAt']->format(\DateTime::ISO8601) : null,
            'place'     => !empty($data['place']) ? [
                'name'     => $data['place'],
                'location' => [
                    'latitude'  => $data['latitude'],
                    'longitude' => $data['longitude']
                ],
            ] : null,
        ]);
    }
}

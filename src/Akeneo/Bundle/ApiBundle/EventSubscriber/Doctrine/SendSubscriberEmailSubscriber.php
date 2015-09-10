<?php

namespace Akeneo\Bundle\ApiBundle\EventSubscriber\Doctrine;

use Akeneo\Bundle\ApiBundle\Document\Event;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendSubscriberEmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var DocumentRepository
     */
    protected $subscriberRepository;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var TwigEngine
     */
    protected $templating;

    /**
     * SendSubscriberEmailSubscriber constructor.
     *
     * @param DocumentRepository $subscriberRepository
     * @param \Swift_Mailer      $mailer
     */
    public function __construct(DocumentRepository $subscriberRepository, \Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->subscriberRepository = $subscriberRepository;
        $this->mailer               = $mailer;
        $this->templating           = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return ['postPersist'];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $document = $args->getDocument();

        if (!$document instanceof Event) {
            return;
        }

        $location = $document->getPlace()->getLocation();

        $subscribers = $this->subscriberRepository->createQueryBuilder()
            ->field('location')
            ->near((float) $location->getLongitude(), (float) $location->getLatitude())
            ->maxDistance(5/111.12) // 5km in radius
            ->getQuery()
            ->execute();


        foreach ($subscribers as $subscriber) {
            $body = $this->templating->render('ApiBundle:Email:subscriber.html.twig', ['event' => $document]);
            $message = \Swift_Message::newInstance()
                ->setSubject('Ping - New event on you area !')
                ->setFrom('no-reply@akeneo.com')
                ->setTo($subscriber->getEmail())
                ->setBody($body, 'text/html');

            $this->mailer->send($message);
        }
    }

}

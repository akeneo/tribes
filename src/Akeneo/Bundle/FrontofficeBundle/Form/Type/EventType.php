<?php

namespace Akeneo\Bundle\FrontofficeBundle\Form\Type;

use Akeneo\Bundle\FrontofficeBundle\Validator\Constraints\Api;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Add event form type
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventType extends AbstractType
{
    /** @var EventSubscriberInterface */
    private $subscriber;

    /** @var array */
    private $tags;

    /**
     * @param EventSubscriberInterface $subscriber
     * @param array                    $tags
     */
    public function __construct(EventSubscriberInterface $subscriber, array $tags = [])
    {
        $this->subscriber = $subscriber;
        $this->tags = $tags;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link', 'url', ['required' => false])
            ->add('place', 'text', ['required' => false])
            ->add('plannedAt', 'datetime', ['widget' => 'single_text', 'required' => false])
            ->add('tags', 'choice', [
                'multiple' => true,
                'choices'  => $this->tags,
                'required' => false
            ])
            ->add('latitude', 'hidden', ['required' => false])
            ->add('longitude', 'hidden', ['required' => false]);

        $builder->addEventSubscriber($this->subscriber);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => new Api(['resource' => 'events'])
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'frontoffice_event';
    }
}

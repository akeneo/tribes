<?php

namespace Akeneo\Bundle\FrontofficeBundle\Form\Type;

use Akeneo\Bundle\FrontofficeBundle\Validator\Constraints\Api;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Add event form type
 *
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AddEventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link', 'url', ['required' => false])
            ->add('place', 'text')
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('plannedAt', 'datetime', ['widget' => 'single_text'])
            ->add('tags', 'choice', [
                'multiple' => true,
                'choices'  => [
                    'akeneo'            => 'Akeneo',
                    'agile'             => 'Agile',
                    'pim'               => 'PIM',
                    'projectmanagement' => 'Project Management',
                    'symfony2'          => 'symfony2',
                    'backbone'          => 'Backbone',
                    'startup'           => 'Start-up',
                ],
            ])
            ->add('latitude', 'hidden', ['required' => false])
            ->add('longitude', 'hidden', ['required' => false]);

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            if (!empty($data['place'])) {
                $name = $data['place'];
                $data['place'] = [
                    'name'     => $name,
                    'location' => [
                        'latitude'  => 37.4224764,
                        'longitude' => -122.0842499
                    ],
                ];
            }
            if (!empty($data['email'])) {
                $data['user']['email'] = $data['email'];
            }
            if (!empty($data['name'])) {
                $data['user']['name'] = $data['name'];
            }
            if (!empty($data['plannedAt'])) {
                $datetime = $data['plannedAt'];
                $data['plannedAt'] = $datetime->format(\DateTime::ISO8601);
            } else {
                unset($data['plannedAt']);
            }

            unset($data['email']);
            unset($data['name']);
            unset($data['latitude']);
            unset($data['longitude']);

            $event->setData($data);
        });
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
        return 'add_event';
    }
}

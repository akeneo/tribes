<?php

namespace Akeneo\Bundle\FrontofficeBundle\Form\Type;

use Akeneo\Bundle\FrontofficeBundle\Validator\Constraints\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Event form type
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
            ->add('plannedAt', 'datetime')
            ->add('tags', 'choice', [
                'multiple' => true,
                'choices'  => [
                    'agile'  => '#agile',
                    'akeneo' => '#akeneo',
                    'pim'    => '#pim',
                ],
            ])
            ->add('send', 'submit');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => new Event()
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

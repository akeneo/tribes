<?php

namespace Akeneo\Bundle\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventType.
 *
 * @author    Clement Gautier <clement.gautier@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class EventType extends AbstractType
{
    /** @var array */
    protected $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link')
            ->add('place', 'place')
            ->add('plannedAt', 'date',
                [
                    'widget' => 'single_text',
                    'required' => true,
                    'format' => 'dd MMMM, y',
                    'attr' => ['class' => 'datepicker']
                ])
            ->add('user', 'user')
            ->add('tags', 'choice', [
                'choices' => $this->tags,
                'multiple' => true,
                'required' => true,
                'attr' => ['class' => 'browser-default']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Akeneo\Bundle\ApiBundle\Document\Event',
            'cascade_validation' => true,
            'csrf_protection' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'event';
    }
}

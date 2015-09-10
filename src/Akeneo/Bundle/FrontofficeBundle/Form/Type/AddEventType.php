<?php

namespace Akeneo\Bundle\FrontofficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('link', 'url')
            ->add('place', 'text', ['required' => true])
            ->add('plannedAt', 'date', ['empty_value' => '', 'widget' => 'single_text', 'required' => true, 'attr' => ['class' => 'datepicker']])
            ->add('tags', 'choice', ['multiple' => true, 'required' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'add_event';
    }
}

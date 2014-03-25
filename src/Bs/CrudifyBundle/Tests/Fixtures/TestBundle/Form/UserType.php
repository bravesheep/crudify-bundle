<?php

namespace Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'required' => true,
            ])
            ->add('city', 'text', [
                'required' => true,
                'property_path' => 'address.city',
            ])
            ->add('street', 'text', [
                'required' => true,
                'property_path' => 'address.street',
            ])
            ->add('enabled', 'checkbox', [
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\User',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_form';
    }
}

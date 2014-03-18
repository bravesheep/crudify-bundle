<?php

namespace Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_form';
    }
}

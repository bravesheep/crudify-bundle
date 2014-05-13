<?php

namespace Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', 'text', [
                'required' => true,
            ])
            ->add('street', 'text', [
                'required' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bs\CrudifyBundle\Tests\Fixtures\TestBundle\Entity\Address',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'address_form';
    }
}

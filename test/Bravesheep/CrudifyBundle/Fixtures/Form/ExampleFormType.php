<?php

namespace Bravesheep\CrudifyBundle\Fixtures\Form;

use Symfony\Component\Form\AbstractType;

class ExampleFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'test_example';
    }
}

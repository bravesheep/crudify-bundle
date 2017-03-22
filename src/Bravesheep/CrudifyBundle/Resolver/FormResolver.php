<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Exception\FormNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormTypeInterface;

class FormResolver implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param mixed $form
     * @return FormTypeInterface
     * @throws FormNotFoundException
     */
    public function resolve($form)
    {
        if (is_string($form)) {
            if ($this->container->has($form)) {
                $form = $this->container->get($form, ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
                if (null !== $form) {
                    $form = get_class($form);
                }
            }
        }

        return $form;
    }
}

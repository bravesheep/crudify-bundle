<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Exception\FormNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Form\FormTypeInterface;

class FormResolver extends ContainerAware
{
    /**
     * @param mixed $form
     * @return FormTypeInterface
     * @throws FormNotFoundException
     */
    public function resolve($form)
    {
        if (is_string($form)) {
            if ($this->container->has($form)) {
                $form = $this->container->get($form);
            } elseif (class_exists($form, true)) {
                $refl = new \ReflectionClass($form);
                if ($refl->implementsInterface('Symfony\Component\Form\FormTypeInterface')) {
                    $constructor = $refl->getConstructor();
                    if (null === $constructor || $constructor->getNumberOfRequiredParameters() === 0) {
                        $form = $refl->newInstance();
                        if ($form instanceof ContainerAwareInterface) {
                            $form->setContainer($this->container);
                        }
                    }
                }
            }
        }

        if (!($form instanceof FormTypeInterface)) {
            throw new FormNotFoundException();
        }
        return $form;
    }
}

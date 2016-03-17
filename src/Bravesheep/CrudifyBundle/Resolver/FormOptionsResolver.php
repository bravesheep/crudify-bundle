<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use Bravesheep\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bravesheep\CrudifyBundle\Exception\CrudifyException;
use Bravesheep\CrudifyBundle\Exception\OptionsProviderNotFoundException;
use Bravesheep\CrudifyBundle\Form\OptionsProvider\OptionsInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class FormOptionsResolver
{
    use ContainerAwareTrait;

    const TYPE_CREATE = 'create';

    const TYPE_UPDATE = 'update';

    public function resolve(FormDefinitionInterface $form, $type, CrudControllerInterface $controller, $object = null)
    {
        $provider = $form->getOptionsProvider();
        if (is_string($provider)) {
            if ($this->container->has($provider)) {
                $provider = $this->container->get($provider);
            } elseif (class_exists($provider, true)) {
                $refl = new \ReflectionClass($provider);
                if ($refl->implementsInterface('Bravesheep\CrudifyBundle\Form\OptionsProvider\OptionsInterface')) {
                    $constructor = $refl->getConstructor();
                    if (null === $constructor || $constructor->getNumberOfRequiredParameters() === 0) {
                        $provider = $refl->newInstance();
                    }
                }
            }
        }

        if (!($provider instanceof OptionsInterface)) {
            $type = $form->getParent()->getName();
            throw new OptionsProviderNotFoundException("No options provider could be found for mapping '{$type}'");
        }

        if ($type === self::TYPE_CREATE) {
            return $provider->getCreateOptions($controller, $form->getParent());
        } elseif ($type === self::TYPE_UPDATE) {
            return $provider->getUpdateOptions($controller, $form->getParent(), $object);
        } else {
            throw new CrudifyException("Invalid form type '{$type}'");
        }
    }
}

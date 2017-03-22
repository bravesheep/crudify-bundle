<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use Bravesheep\CrudifyBundle\Exception\ControllerNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ControllerResolver implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $defaultController;

    private $resolved;

    public function __construct($defaultController = null)
    {
        $this->defaultController = $defaultController;
        $this->resolved = [];
    }

    /**
     * @param null|string|CrudControllerInterface $controller
     * @return CrudControllerInterface
     * @throws ControllerNotFoundException
     */
    public function resolve($controller)
    {
        if (null === $controller) {
            $controller = $this->defaultController;
        }
        $name = $controller;

        if (is_string($controller)) {
            if (isset($this->resolved[$controller])) {
                return $this->resolved[$controller];
            }

            if ($this->container->has($controller)) {
                $controller = $this->container->get($controller);
            } elseif (class_exists($controller, true)) {
                $refl = new \ReflectionClass($controller);
                if ($refl->implementsInterface('Bravesheep\CrudifyBundle\Controller\CrudControllerInterface')) {
                    if ($refl->getConstructor() === null ||
                        $refl->getConstructor()->getNumberOfRequiredParameters() === 0
                    ) {
                        $controller = $refl->newInstance();
                        $controller->setContainer($this->container);
                    }
                }
            }
        }

        if (!($controller instanceof CrudControllerInterface)) {
            throw new ControllerNotFoundException("Could not resolve controller specification to controller");
        }

        if (is_string($name)) {
            $this->resolved[$name] = $controller;
        }

        return $controller;
    }
}

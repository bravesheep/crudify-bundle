<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Symfony\Component\Routing\RouterInterface;

class LinkResolver
{
    /**
     * @var IdentityResolver
     */
    private $identityResolver;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router, IdentityResolver $identityResolver)
    {
        $this->router = $router;
        $this->identityResolver = $identityResolver;
    }

    /**
     * @param string              $action
     * @param DefinitionInterface $definition
     * @param object|null         $object
     * @return string
     */
    public function getLinkForAction($action, DefinitionInterface $definition, $object = null)
    {
        $parameters = [
            'mapping' => $definition->getName(),
        ];

        if (is_object($object)) {
            $parameters['id'] = $this->identityResolver->getId($definition, $object);
        } elseif (is_int($object)) {
            $parameters['id'] = $object;
        }
        $route = "bs_crudify.{$action}";
        return $this->router->generate($route, $parameters);
    }
}

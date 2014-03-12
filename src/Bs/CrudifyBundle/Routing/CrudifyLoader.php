<?php

namespace Bs\CrudifyBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CrudifyLoader extends Loader
{
    private $defaultMapping;

    public function __construct($defaultMapping = null)
    {
        $this->defaultMapping = $defaultMapping;
    }

    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();

        if ($this->defaultMapping !== null) {
            $route = new Route('/', [
                '_controller' => 'FrameworkBundle:Redirect:redirect',
                'route' => 'bs_crudify.index',
                'permanent' => true,
                'mapping' => $this->defaultMapping,
            ]);
            $routes->add('bs_crudify.homepage_redirect', $route);
        }


        $mappingReq = ['mapping' => '\w+'];
        $mappingIdReq = array_merge($mappingReq, ['id' => '\d+']);

        $this->addRoute('index', '/{mapping}', 'indexAction', $mappingReq, ['GET'], $routes);
        $this->addRoute('new', '/{mapping}/new', 'newAction', $mappingReq, ['GET'], $routes);
        $this->addRoute('create', '/{mapping}', 'createAction', $mappingReq, ['POST'], $routes);
        $this->addRoute('edit', '/{mapping}/{id}/edit', 'editAction', $mappingIdReq, ['GET'], $routes);
        $this->addRoute('update', '/{mapping}/{id}', 'updateAction', $mappingIdReq, ['PUT', 'PATCH'], $routes);
        $this->addRoute('delete', '/{mapping}/{id}', 'deleteAction', $mappingIdReq, ['DELETE'], $routes);
        return $routes;
    }

    public function addRoute($name, $path, $action, array $requirements, array $methods, RouteCollection $routes)
    {
        $route = new Route(
            $path,
            ['_controller' => "bs_crudify.controller:{$action}"],
            $requirements,
            [],
            '',
            [],
            $methods
        );
        $routes->add("bs_crudify.{$name}", $route);
    }

    public function supports($resource, $type = null)
    {
        return $type === 'crudify';
    }
}

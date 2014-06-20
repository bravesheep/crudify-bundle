<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

require_once __DIR__ . '/../../autoload.php';

Debug::enable();

require_once __DIR__ . '/../../AppKernel.php';

$kernel = new Bravesheep\CrudifyBundle\Tests\Fixtures\App\AppKernel('dev', true);
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

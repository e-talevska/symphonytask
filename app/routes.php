<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('/', new Routing\Route('/', array(
    '_controller' => 'QuickBetOnline\Controllers\BetController::indexAction',
)));

$routes->add('/conversion', new Routing\Route('/conversion/save', array(
    '_controller' => 'QuickBetOnline\Controllers\ConversionLogController::saveAction',
    'methods' => ['POST']
)));

return $routes;
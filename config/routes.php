<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
	$builder->connect('/', ['controller' => 'Home', 'action' => 'index']);
	
	$builder->fallbacks();
});

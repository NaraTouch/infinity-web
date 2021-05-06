<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
//	$builder->connect('/applications/*', ['controller' => 'Applications', 'action' => 'app']);
	$builder->connect('/*', ['controller' => 'Applications', 'action' => 'app']);
	$builder->connect('/setting/auth', ['controller' => 'Setting', 'action' => 'auth']);
	$builder->connect('/setting/layout', ['controller' => 'Setting', 'action' => 'layout']);
	$builder->fallbacks();
});

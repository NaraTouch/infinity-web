<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
//	$builder->connect('/applications/*', ['controller' => 'Applications', 'action' => 'app']);
	$builder->connect('/*', ['controller' => 'Applications', 'action' => 'app']);
	$builder->connect('/setting/auth', ['controller' => 'Setting', 'action' => 'auth']);
	$builder->connect('/setting/layout', ['controller' => 'Setting', 'action' => 'layout']);
	
	// File Upload
	$builder->connect('/files/upload-file', ['controller' => 'Files', 'action' => 'uploadFile']);
	$builder->connect('/files/delete-file', ['controller' => 'Files', 'action' => 'deleteFile']);
	$builder->connect('/files/rename-file', ['controller' => 'Files', 'action' => 'renameFile']);
	
	// Folder
	$builder->connect('/files/create-folder', ['controller' => 'Files', 'action' => 'createFolder']);
	$builder->connect('/files/delete-folder', ['controller' => 'Files', 'action' => 'deleteFolder']);
	$builder->connect('/files/rename-folder', ['controller' => 'Files', 'action' => 'renameFolder']);
	
	//Listing
	$builder->connect('/files/listing', ['controller' => 'Files', 'action' => 'listing']);
	
	$builder->fallbacks();
});

<?php
namespace App\Controller;

class ApplicationsController extends AppController
{

	private $directory;
	private $authorization;
	private $layout;
	public function initialize(): void
	{
		$this->loadComponent('Setting');
		$this->loadComponent('User');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
		$this->directory = WWW_ROOT.'properties';
		$this->authorization = 'authorization.json';
		$this->layout = 'layout.json';
	}

	public function app()
	{
//		$read_layout = $this->readFile($this->directory, $this->layout);
//		dump($read_layout);
//		die();
		
	}
}

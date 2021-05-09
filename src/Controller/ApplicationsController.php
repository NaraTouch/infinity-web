<?php
namespace App\Controller;

class ApplicationsController extends AppController
{

	public function initialize(): void
	{
		$this->loadComponent('Setting');
		$this->loadComponent('User');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
	}

	public function app()
	{
		$check_layout = $this->checkFile(DIR_PROPERTIES, FILE_LAYOUT);
		if (!$check_layout) {
			return $this->goingToUrl('Setting', 'auth');
		} else {
			$tag_link = strtolower($this->request->getUri()->getPath());
			$layout = $this->readFile(DIR_PROPERTIES, FILE_LAYOUT);
			if ($tag_link == '/') {
				dump();
				dump($tag_link);
			}
		}
	}
}

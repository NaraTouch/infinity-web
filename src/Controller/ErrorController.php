<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Event\EventInterface;

class ErrorController extends AppController
{
	
	public function initialize(): void
	{
		$this->loadComponent('RequestHandler', [
			'enableBeforeRedirect' => false,
		]);
	}
	public function beforeFilter(EventInterface $event)
	{
	}
	public function beforeRender(EventInterface $event)
	{
		parent::beforeRender($event);
		$error = $this->response->getStatusCode();
//		if ($error != 200) {
//			return $this->redirect(['controller' => 'Error', 'action' => 'error404']);
//		}
	}
	public function afterFilter(EventInterface $event)
	{
	}

	public function error404()
	{
		$this->viewBuilder()->disableAutoLayout();
	}
}

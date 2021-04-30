<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class AppController extends Controller
{
	private $directory;
	private $authorization;
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
	}

	public function beforeFilter(EventInterface $event)
	{
		$this->directory = WWW_ROOT.'properties';
		$this->authorization = 'authorization.json';
	
		parent::beforeFilter($event);
		$this->Auth->allow();
		$this->webLoader();
		
//		$check_auth = $this->checkFile($this->authorization);
//		if ($check_auth) {
//			$this->webLoader();
//		} else {
////			$this->redirect([
////				'controller' => 'Setting',
////				'action' => 'index'
////			]);
//		}
	}

	public function getSession()
	{
		return $this->request->getSession();
	}

	public function readSession($key)
	{
		return $this->getSession()->read($key);
	}

	public function writeSession($key, $value)
	{
		return $this->getSession()->write($key, $value);
	}

	public function deleteSession($key)
	{
		return $this->getSession()->delete($key);
	}

	public function webLoader()
	{
		$controller = strtolower($this->request->getParam('controller'));
		$action = strtolower($this->request->getParam('action'));
		if ($controller != 'setting' && $action != 'auth') {
			$check_auth = $this->checkFile($this->authorization);
			if (!$check_auth) {
				return $this->redirect(['controller' => 'Setting', 'action' => 'auth']);
			} else {
				return $this->redirect(['controller' => 'Setting', 'action' => 'setting']);
			}
		}
	}
	
	// Default Directory
	// WWW_ROOT.'properties'
	// $file = 'authorization.json';
	public function createFile($file = null)
	{
		if (!$file) {
			return false;
		} else {
			$check = file_exists($this->directory.'/'.$file);
			if (!$check) {
				$create = new File($this->directory.'/'.$file, true);
				if (!$create) {
					return false;
				} else {
					return [
						'directory' => $this->directory,
						'file' => $file
					];
				}
			} else {
				return [
					'directory' => $this->directory,
					'file' => $file
				];
			}
		}
	}

	// $file = 'authorization.json';
	public function checkFile($file = null)
	{
		if (!$file) {
			return false;
		} else {
			$check = file_exists($this->directory.'/'.$file);
			if (!$check) {
				return false;
			} else {
				return true;
			}
		}
	}

	// $json = '{"key":"value"}';
	// $this->writeFile($file['directory'], $file['file'], $json);
	public function writeFile($directory = null, $file = null, $json = null)
	{
		if (!$directory || !$file || !$json) {
			return false;
		} else {
			$write = new File($directory.'/'.$file, true);
			return $write->write($json);
		}
	}
	
	// $this->readFile($file['directory'], $file['file']);
	public function readFile($directory = null, $file = null)
	{
		if (!$directory || !$file) {
			return false;
		} else {
			$read = new File($directory.'/'.$file, true);
			$json = $read->read(true, 'r');
			return json_decode($json);
		}
	}

}

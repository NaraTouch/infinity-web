<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Filesystem\File;

class AppController extends Controller
{
	
	public function initialize(): void
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
	}

	public function beforeFilter(EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow();
		$this->webLoader();
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
		$check_auth = $this->checkFile(DIR_PROPERTIES, FILE_AUTHORIZATION);
		if (!$check_auth) {
			if ($controller != 'setting' && $action != 'auth') {
				return $this->goingToUrl('Setting', 'auth');
			}
		} else {
			$check_layout = $this->checkFile(DIR_PROPERTIES, FILE_LAYOUT);
			if (!$check_layout) {
				if ($controller != 'setting' && $action != 'layout') {
					return $this->goingToUrl('Setting', 'layout');
				}
			}
		}
	}
	
	// Default Directory
	// WWW_ROOT.'properties'
	// $file = 'authorization.json';
	public function createFile($directory = null, $file = null)
	{
		if (!$file) {
			return false;
		} else {
			$check = file_exists($directory.'/'.$file);
			if (!$check) {
				$create = new File($directory.'/'.$file, true);
				if (!$create) {
					return false;
				} else {
					return [
						'directory' => $directory,
						'file' => $file
					];
				}
			} else {
				return [
					'directory' => $directory,
					'file' => $file
				];
			}
		}
	}

	// $file = 'authorization.json';
	public function checkFile($directory = null, $file = null)
	{
		if (!$file) {
			return false;
		} else {
			$check = file_exists($directory.'/'.$file);
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

	public function goingToHome()
	{
		return $this->redirect('/');
	}

	public function goingToUrl($controller = null, $action = null, $param = null)
	{
		return $this->redirect([
			'controller' => $controller,
			'action' => $action,
			$param
		]);
	}

}

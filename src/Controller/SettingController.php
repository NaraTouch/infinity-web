<?php
namespace App\Controller;

class SettingController extends AppController
{

	private $directory;
	private $authorization;
	public function initialize(): void
	{
		$this->loadComponent('Setting');
		$this->loadComponent('User');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
		$this->directory = WWW_ROOT.'properties';
		$this->authorization = 'authorization.json';
	}
	
	public function auth()
	{
		$this->viewBuilder()->disableAutoLayout();
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			$user = $this->User->login($request);
			if($user){
				$user = json_decode($user, true);
				if ($user['ErrorCode'] == 200) {
					$token = $user['Data']['token'];
					$authorization = $this->Setting->authorization($token);
					if ($authorization) {
						$authorization = json_decode($authorization, true);
						if ($authorization['ErrorCode'] == 200) {
							$data = $authorization['Data'];
							$this->writeSettingFile(json_encode($data));
							return $this->redirect('/');
						} else {
							$this->Flash->errorsetting($authorization['Message']);
						}
					}
				} else {
					$this->Flash->errorsetting($user['Message']);
				}
			}
		}
	}

	public function setting()
	{
		dump('setting');
	}
	// $json most be in json
	// example $file = 'authorization.json';
	public function writeSettingFile($json = null)
	{
		if (!$json) {
			return false;
		}
		if ($this->checkFile($this->authorization)) {
			return $this->writeFile($this->directory, $this->authorization, $json);
		} else {
			$create_file = $this->createFile($this->authorization);
			if ($create_file) {
				return $this->writeFile($this->directory, $this->authorization, $json);
			} else {
				return false;
			}
		}
		
	}
}

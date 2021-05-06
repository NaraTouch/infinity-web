<?php
namespace App\Controller;

class SettingController extends AppController
{

	public function initialize(): void
	{
		$this->loadComponent('Setting');
		$this->loadComponent('User');
		$this->loadComponent('Auth');
		$this->loadComponent('Flash');
	}

	public function auth()
	{
		$check_auth = $this->checkFile(DIR_PROPERTIES, FILE_AUTHORIZATION);
		$token = null;
		if(!$check_auth) {
			$this->viewBuilder()->disableAutoLayout();
			if ($this->request->is('post')) {
				$request = $this->request->getData();
				$user = $this->User->login($request);
				if($user){
					$user = json_decode($user, true);
					$token = $user['Data']['token'];
					if ($user['ErrorCode'] == 200) {
						$authorization = $this->Setting->authorization($token);
						if ($authorization) {
							$authorization = json_decode($authorization, true);
							if ($authorization['ErrorCode'] == 200) {
								$data = $authorization['Data'];
								$data_token = $user['Data'];
								$this->writeSettingFile(json_encode($data_token), FILE_TOKEN);
								$this->writeSettingFile(json_encode($data), FILE_AUTHORIZATION);
								return $this->goingToUrl('Setting', 'layout');
							} else {
								$this->Flash->errorsetting($authorization['Message']);
							}
						}
					} else {
						$this->Flash->errorsetting($user['Message']);
					}
				}
			}
		} else {
			return $this->goingToHome();
		}
	}

	public function layout()
	{
		$this->viewBuilder()->disableAutoLayout();
		$check_layout = $this->checkFile(DIR_PROPERTIES, FILE_LAYOUT);
		if (!$check_layout) {
			$token = $this->checkFile(DIR_PROPERTIES, FILE_TOKEN);
			if ($token) {
				$get_token = $this->readFile(DIR_PROPERTIES, FILE_TOKEN);
				if ($get_token) {
					$layouts = [];
					$token = $get_token->token;
					if ($this->request->is('get')) {
						$layout = $this->Setting->weblayouts($token);
						if ($layout) {
							$layout = json_decode($layout, true);
							if ($layout['ErrorCode'] == 200) {
								$layouts = $layout['Data'];
								$this->writeSettingFile(json_encode($layouts), FILE_LAYOUT);
							} else {
								return $this->goingToUrl('Setting', 'auth');
							}
						} else {
							return $this->goingToUrl('Setting', 'auth');
						}
					}
					if ($this->request->is('post')) {
						return $this->goingToHome();
					}
					$this->set([
						'layouts' => $layouts,
					]);
				} else {
					return $this->goingToUrl('Setting', 'auth');
				}
			} else {
				return $this->goingToUrl('Setting', 'auth');
			}
		} else {
			return $this->goingToUrl('Setting', 'auth');
		}
		
	}
	// $json most be in json
	// example $file = 'authorization.json';
	public function writeSettingFile($json = null ,$file_name = null)
	{
		if (!$json || !$file_name) {
			return false;
		}
		if ($this->checkFile(DIR_PROPERTIES, $file_name)) {
			return $this->writeFile(DIR_PROPERTIES, $file_name, $json);
		} else {
			$create_file = $this->createFile(DIR_PROPERTIES, $file_name);
			if ($create_file) {
				return $this->writeFile(DIR_PROPERTIES, $file_name, $json);
			} else {
				return false;
			}
		}
		
	}
}

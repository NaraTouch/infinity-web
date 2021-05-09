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
								$this->writeTokenFile($data_token);
								$this->writeAuthFile($data);
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
								$this->writeMenuFile($layouts);
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

	public function  writeMenuFile($data = null)
	{
		$layout = [];
		foreach($data as $key => $value) {
			$layout[] = [
				'name' => $value['name'],
				'display' => $value['display'],
				'tag_links' => $value['tag_links'],
				'icon' => $value['icon'],
			];
			if (!empty($value['subpages'])) {
				foreach($value['subpages'] as $k => $v) {
					$layout[$key]['subpages'][] = [
						'name' => $v['name'],
						'display' => $v['display'],
						'tag_links' => $v['tag_links'],
						'icon' => $v['icon'],
						'code' => $v['code'],
					];
					if (!empty($v['layouts'])) {
						$this->writeComponentFile($v['layouts'], $v['name'], $v['tag_links']);
					}
				}
			}
		}
		return $this->writeSettingFile(json_encode($layout), FILE_LAYOUT);
	}

	public function  writeComponentFile($data = null, $name = null, $tag_links = null)
	{
		$file_name = $name.'-'.$tag_links.'.json';
		$component= [];
		foreach($data as $key => $value) {
			$component[] = [
				'name' => $value['component']['name'],
				'table_name' => $value['component']['table_name'],
				'description' => $value['component']['description'],
			];
		}
		return $this->writeSettingFile(json_encode($component), $file_name);
	}

	public function writeTokenFile($data = null)
	{
		$token['token'] = $data['token'];
		return $this->writeSettingFile(json_encode($token), FILE_TOKEN);
	}
	
	public function writeAuthFile($data = null)
	{
		$auth = [
			'name' => $data['name'],
			'domain' => $data['domain'],
			'display' => $data['display'],
			'code' => $data['code'],
		];
		return $this->writeSettingFile(json_encode($auth), FILE_AUTHORIZATION);
	}
}

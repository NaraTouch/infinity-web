<?php
namespace App\Controller;
use Cake\Filesystem\File;

class FilesController extends AppController
{

	public function initialize(): void
	{
		$this->loadComponent('Auth');
		$this->loadComponent('Validation');
		$this->loadComponent('Response');
		$this->autoRender = false;
		$this->layout = false;
	}

	public function renameFile()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$request_body = $this->request->input('json_decode');
			$data = (array) $request_body;
			$validate = $this->Validation->validateRenameFile($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$path = $data['path'];
				$name = $data['name'];
				$to_name = $data['to_name'];
				$dir = DIR_UPLOAD.$path;
				$check_file = $this->checkFile($dir, $name);
				if ($check_file) {
					$old_url = $dir.'\\'.$name;
					$new_url = $dir.'\\'.$to_name;
					rename($old_url,$new_url);
					$http_code = 200;
					$message = 'success';
					$response = $this->Response->Response($http_code, $message, $data, null);
				} else {
					$http_code = 404;
					$message = 'file not found';
					$response = $this->Response->Response($http_code, $message, $data, null);
				}
			} else {
				$http_code = 201;
				$message = 'Delete Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}

	public function deleteFile()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$request_body = $this->request->input('json_decode');
			$data = (array) $request_body;
			$validate = $this->Validation->validateDeleteFile($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$path = $data['path'];
				$name = $data['name'];
				$file_dir = new File(DIR_UPLOAD.$path.'\\'.$name);
				$file_dir->delete();
				$file_dir->close();
				$http_code = 200;
				$message = 'success';
				$response = $this->Response->Response($http_code, $message, $data, null);
			} else {
				$http_code = 201;
				$message = 'Delete Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}
	
	public function uploadFile()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$validate = $this->Validation->validateUploadFile($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$file = $data['file'];
				$path = $data['path'];
				$name = $file->getClientFilename();
				$directory = DIR_UPLOAD.$path;
				$check = $this->checkDirectory($directory);
				$targetPath = $directory.'\\'.$name;
				if (!$check) {
					$create_dir = $this->createDirectory($directory);
					if ($create_dir) {
						$upload = $this->uploadingFile($file, $targetPath, $name, $path);
						if ($upload['status']) {
							$http_code = 200;
							$message = 'success';
							$response = $this->Response->Response($http_code, $message, $upload['data'], null);
						} else {
							$http_code = 201;
							$message = 'upload failed';
							$response = $this->Response->Response($http_code, $message, null, null);
						}
					} else {
						$http_code = 403;
						$message = 'cannot create directory';
						$response = $this->Response->Response($http_code, $message, $data, null);
					}
				} else {
					$upload = $this->uploadingFile($file, $targetPath, $name, $path);
					if ($upload['status']) {
						$http_code = 200;
						$message = 'success';
						$response = $this->Response->Response($http_code, $message, $upload['data'], null);
					} else {
						$http_code = 201;
						$message = 'upload failed';
						$response = $this->Response->Response($http_code, $message, null, null);
					}
				}
			} else {
				$http_code = 201;
				$message = 'Upload Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}

	public function uploadingFile($file = null, $targetPath = null, $name = null, $path = null)
	{
		$data = [];
		$status = false;
		if ($file->getSize() > 0 && $file->getError() == 0) {
			$file->moveTo($targetPath);
			$type = explode('/', $file->getClientMediaType());
			$data = [
				'url_path' => $targetPath,
				'orgin_path' => $path.'\\'.$name,
				'name' => $name,
				'type' => $type[1],
				'size' => $file->getSize(),
			];
			$status = true;
		}
		return [
			'status' => $status,
			'data' => $data
		];
	}

	public function deleteFolder()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$request_body = $this->request->input('json_decode');
			$data = (array) $request_body;
			$validate = $this->Validation->validateDeleteFolder($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$directory = DIR_UPLOAD.$data['path'];
				$check = $this->checkDirectory($directory);
				if ($check) {
					if ($this->isDirEmpty($directory)) {
						rmdir($directory);
						$http_code = 200;
						$message = 'success';
						$response = $this->Response->Response($http_code, $message, $data, null);
					} else {
						$http_code = 203;
						$message = 'Directory not empty';
						$response = $this->Response->Response($http_code, $message, $data, null);
					}
				} else {
					$http_code = 200;
					$message = 'Directory not exist';
					$response = $this->Response->Response($http_code, $message, $data, null);
				}
			} else {
				$http_code = 201;
				$message = 'Delete Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}
	
	public function createFolder()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$request_body = $this->request->input('json_decode');
			$data = (array) $request_body;
			$validate = $this->Validation->validateCreateFolder($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$directory = DIR_UPLOAD.$data['path'];
				$create_dir = $this->createDirectory($directory);
				if ($create_dir) {
					$data['directory'] = $directory;
					$http_code = 200;
					$message = 'success';
					$response = $this->Response->Response($http_code, $message, $data, null);
				} else {
					$http_code = 403;
					$message = 'Cannot create directory';
					$response = $this->Response->Response($http_code, $message, $data, null);
				}
			} else {
				$http_code = 201;
				$message = 'Create Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}

	public function renameFolder()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$request_body = $this->request->input('json_decode');
			$data = (array) $request_body;
			$validate = $this->Validation->validateRenameFolder($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$path_name = DIR_UPLOAD.$data['path_name'];
				$to_path_name = DIR_UPLOAD.$data['to_path_name'];
				$check = $this->checkDirectory($path_name);
				if ($check) {
					rename($path_name,$to_path_name);
					$http_code = 200;
					$message = 'success';
					$response = $this->Response->Response($http_code, $message, $data, null);
				} else {
					$http_code = 200;
					$message = 'Directory not exist';
					$response = $this->Response->Response($http_code, $message, $data, null);
				}
			} else {
				$http_code = 201;
				$message = 'Delete Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}

	public function listing()
	{
		$http_code = 404;
		$response = $this->Response->Message($http_code);
		if ($this->request->is('post')) {
			$request_body = $this->request->input('json_decode');
			$data = (array) $request_body;
			$validate = $this->Validation->validateListing($data);
			unset($data['secret_key']);
			if (empty($validate)) {
				$path = DIR_UPLOAD.$data['path'];
				$check = $this->checkDirectory($path);
				if ($check) {
					$info_list = $this->listingAll($path);
					$http_code = 200;
					$message = 'success';
					$response = $this->Response->Response($http_code, $message, $info_list, null);
				} else {
					$http_code = 200;
					$message = 'Directory not exist';
					$response = $this->Response->Response($http_code, $message, $data, null);
				}
			} else {
				$http_code = 201;
				$message = 'Delete Failed!!!';
				$response = $this->Response->Response($http_code, $message, null, $validate);
			}
		}
		return $this->response->withType('application/json')
			->withStatus($http_code)
			->withStringBody(json_encode($response));
	}

	public function listingAll($path = null)
	{
		$arr_listing = array_diff(scandir($path), ['.', '..']);
		if (!empty($arr_listing)) {
			$data = [];
			foreach($arr_listing as $key => $value) {
				$dir_path = $path.$value;
				if (is_dir($dir_path)) {
					$data[$value] = [
						'type' => 'folder',
						'info' => [],
					];
				} else {
					$info = $this->getFileInfo($dir_path);
					$data[$value] = [
						'type' => 'file',
						'info' => $info,
					];
				}
				
			}
			return $data;
		}
		return [];
	}
	
	public function getFileInfo($path_file = null)
	{
		$file = new File($path_file);
		$info = $file->info();
		if ($info) {
			return $info;
		}
		return [];
	}
	
	public function isDirEmpty($dir = null)
	{
		if (!is_readable($dir)) return null; 
		return (count(scandir($dir)) == 2);
	}
}
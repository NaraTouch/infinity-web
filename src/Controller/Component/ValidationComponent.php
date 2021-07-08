<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Validation\Validator;

class ValidationComponent extends Component
{

	private $validator;

	public function initialize(array $config): void
	{
		parent::initialize($config);
		$this->validator = new Validator();
	}

	// Rename Folder
	public function validateListing($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');

		$this->validator
			->requirePresence('path')
			->notEmpty('path')
			->add('path', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);

		return $this->validator->errors($data);
	}

	// Rename Folder
	public function validateRenameFolder($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');

		$this->validator
			->requirePresence('path_name')
			->notEmpty('path_name')
			->add('path_name', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);

		$this->validator
			->requirePresence('to_path_name')
			->notEmpty('to_path_name')
			->add('to_path_name', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);
		return $this->validator->errors($data);
	}

	// Create Folder
	public function validateDeleteFolder($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');

		$this->validator
			->requirePresence('path')
			->notEmpty('path')
			->add('path', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);
		return $this->validator->errors($data);
	}

	// Create Folder
	public function validateCreateFolder($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');

		$this->validator
			->requirePresence('path')
			->notEmpty('path')
			->add('path', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);
		return $this->validator->errors($data);
	}

	// Rename File
	public function validateRenameFile($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');
	
		$this->validator
			->requirePresence('name')
			->notEmptyString('name');

		$this->validator
			->requirePresence('to_name')
			->notEmptyString('to_name');

		$this->validator
			->requirePresence('path')
			->notEmpty('path')
			->add('path', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);
		return $this->validator->errors($data);
	}

	// Delete File
	public function validateDeleteFile($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');
	
		$this->validator
			->requirePresence('name')
			->notEmptyString('name');

		$this->validator
			->requirePresence('path')
			->notEmpty('path')
			->add('path', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);
		return $this->validator->errors($data);
	}

	// Upload File
	public function validateUploadFile($data = [])
	{

		$this->validator
			->requirePresence('secret_key')
			->notEmptyString('secret_key');
	
		$this->validator
			->requirePresence('file')
			->notEmpty('file')
			->add('file', 'custom', [
				'rule' => function($value) {
				$type = $value->getClientMediaType();
					$_ext = explode('/', $type);
					if (!in_array(strtolower($_ext[1]), IMAGE_EXTENTION)) {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_FILE,
			]);
		$this->validator
			->requirePresence('path')
			->notEmpty('path')
			->add('path', 'custom', [
				'rule' => function($value) {
					$dir = $value['0'];
					if ($dir !== '\\') {
						return false;
					} else {
						return true;
					}
				},
				'message' => MESSAGE_INVALIDE_DIR,
			]);
		return $this->validator->errors($data);
	}
	
}
<?php
namespace App\Controller\Component;
use Cake\Controller\Component;

class FrontEndComponent extends Component
{
	private $api_url;

	public function initialize(array $config): void
	{
		parent::initialize($config);
		$this->api_url = 'http://localhost/infinity-api';
	}

	public function getComponentData($request_data = [])
	{
		$data = [];
		$response = $this->frontEnd($request_data);
		if($response){
			$response = json_decode($response);
			if ($response && $response->ErrorCode == 200) {
				$data = $response->Data;
			}
		}
		return $data;
	}

	public function frontEnd($data = [])
	{
		$url = $this->api_url.'/front-end';
		$http_method = 'POST';
		return $this->openUrlWithToken($url, $http_method, $data);
	}

	private function openUrlWithToken($url = null, $http_method = null, $request = [])
	{
		if (!$url) {
			return [];
		}
		$response = [];
		$json = json_encode($request);
		$header = [
			'Content-Type: application/json',
		];
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $http_method,
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_POSTFIELDS => $json,
		]);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

}
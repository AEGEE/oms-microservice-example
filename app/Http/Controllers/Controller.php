<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Models\Option;

use GuzzleHttp\Client;

class Controller extends BaseController
{
	public function registerMicroservice(Option $opt) {
		$opt = $opt->where('code', 'handshake_token')->first();
		if($opt != null) {
			$toReturn['success'] = 0;
			$toReturn['message'] = "Service already registered!";
			return response(json_encode($toReturn), 200);
		}

		$client = new Client();

		$pages = array();
		$pages[] = array(
			'name'			=>	'Hello world',
			'code'			=>	'hello_world',
			'module_link' 	=>	'frontend/hello_world/hello_world.js',
			'icon'			=>	'fa fa-star'
		);

		$formParams = array(
			'name'		=>	'Module Poc',
			'code'		=>	'module_poc',
			'base_url'	=>  env('APP_URL'),
			'pages'		=>	json_encode($pages)
		);

		$headers = array(
			'X-Requested-With'	=>	'XMLHttpRequest',
			'X-Api-Key'			=>	env('CORE_API')
		);

		$response = $client->request('POST', env('CORE_URL')."/api/registerMicroservice", [
			'form_params'	=>	$formParams,
			'headers'		=>	$headers
		]);

		$responseSerialized = $response->getBody();
		$responseDeserialized = json_decode($responseSerialized);

		if($responseDeserialized->success == 0) {
			return response($responseSerialized, 200);
		}

		$opt = new Option();
        $opt->name = "Handshake token";
        $opt->code = "handshake_token";
        $opt->not_editable = 1;
        $opt->value = $responseDeserialized->handshake_token;
        $opt->save();

        $toReturn['success'] = 1;
		return response(json_encode($toReturn), 200);
	}

    public function getUserData(Option $opt) {
    	$xAuthToken = isset($_SERVER['HTTP_X_AUTH_TOKEN']) ? $_SERVER['HTTP_X_AUTH_TOKEN'] : '';
    	if(empty($xAuthToken)) {
			return response('Forbidden', 403);
    	}

    	$headers = $opt->getRequestHeaders();

    	$formParams = array(
    		'token'	=>	$xAuthToken
    	);

    	$client = new Client();
    	$response = $client->request('POST', env('CORE_URL')."/api/getUserByToken", [
			'form_params'	=>	$formParams,
			'headers'		=>	$headers
		]);

		$responseSerialized = $response->getBody();
		$responseDeserialized = json_decode($responseSerialized);

		if($responseDeserialized->success == 0) {
			return response($responseSerialized, 200);
		}

		$toReturn['success'] = 1;
		$toReturn['user'] = $responseDeserialized->user;
		return response(json_encode($toReturn), 200);
    }
}

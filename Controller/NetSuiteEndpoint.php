<?php

namespace NetSuite\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Exception\ClientException;

class NetSuiteEndpoint {
	private $client;

	public function __construct($base_uri, $oauth) {
		$stack = HandlerStack::create();
		$middleware = new Oauth1($oauth);
		$stack->push($middleware);
		$this->client = new Client([
			'base_uri' => $base_uri,
			'handler' => $stack,
			'http_errors' => false,
			'auth' => 'oauth'
		]);
	}

	public function query($endpoint = '') {
		$res = $this->client->request('GET', $endpoint);
		return json_decode($res->getBody(), true);
	}

	public function post($endpoint = '', $data) {
		try {
			$res = $this->client->request('POST', $endpoint, [
				'json' => $data
			]);
			if($res->getStatusCode() === 204) {
				// this is mostly a hack, but lets return the last segment of the location
				$location = $res->getHeader('Location');
				return [
					'status' => 'success',
					'id' => $location
				];
			} else {
				return json_decode($res->getBody(), true);
			}
		} catch (ClientException $e) {
			$res = $e->getResponse();
			return json_decode($res->getBody()->getContents(), true);
		}
		return 'something else happened here...';
	}

	public function delete($endpoint) {
		if(!isset($endpoint)) {
			return 'Please provide a valid endpoint';
		}

		$res = $this->client->request('DELETE', $endpoint);

		return json_decode($res->getBody(), true);
	}

	public function renderResponse($res, $return_fn) {

		/* $status = $res->requestStatus;

		if ( !$status->success ) {
			return $status;		
		} */

		return $return_fn($res);
	}

}

?>
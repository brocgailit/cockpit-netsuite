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
			return json_decode($res->getBody(), true);
		} catch (ClientException $e) {
			$res = $e->getResponse();
			return json_decode($res->getBody()->getContents(), true);
		}
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
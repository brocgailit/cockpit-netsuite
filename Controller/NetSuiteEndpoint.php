<?php

namespace NetSuite\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class NetSuiteEndpoint {
	private $client;

	public function __construct($base_uri, $oauth) {
		$stack = HandlerStack::create();
		$middleware = new Oauth1($oauth);
		$stack->push($middleware);
		$this->client = new Client([
			'base_uri' => $base_uri,
			'handler' => $stack
		]);
	}

	public function query($endpoint = '', $options = []) {
		$q = Psr7\build_query($options);
		$res = $this->client->request('GET', $endpoint, [
			'auth' => 'oauth',
			'query' => $q
		]);
		return json_decode($res->getBody(), true);
	}

	public function post($endpoint = '', $data) {
		$res = $this->client->request('POST', $endpoint, [
			'auth' => 'oauth',
			'json' => $data
		]);
		return json_decode($res->getBody(), true);
	}

	public function delete($endpoint) {
		if(!isset($endpoint)) {
			return 'Please provide a valid endpoint';
		}

		$res = $this->client->request('DELETE', $endpoint, [
			'auth' => 'oauth'
		]);

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
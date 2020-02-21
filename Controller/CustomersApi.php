<?php

namespace NetSuite\Controller;

use \LimeExtra\Controller;
use NetSuite\Controller\NetSuiteEndpoint;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class CustomersApi extends Controller {
	private $netsuite;
	private $options;
	private $config;

	public function __construct($options) {
		parent::__construct($options);
		$this->options = $options;
		$config = $this->app['config']['netsuite'];
		$this->config = $config;
        $this->netsuite = new NetSuiteEndpoint(
            "https://{$config['account']}.suitetalk.api.netsuite.com/services/rest/record/v1/customer/",
            [
				'consumer_key'    	=> $config['consumer_key'],
				'consumer_secret' 	=> $config['consumer_secret'],
				'token'           	=> $config['token_id'],
				'token_secret'    	=> $config['token_secret'],
				'signature_method'	=> Oauth1::SIGNATURE_METHOD_HMACSHA256,
				'version'			=> '1.0',
				'realm'				=> $config['account']
			]
        );
    }
    
    public function index() {
		return 'Customers API';
	}

	public function customer($customer_id = '') {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->netsuite->post('', $data);
		}

		/* if($this->req_is('delete')) {
			return $this->netsuite->delete($customer_id);
		} */

		return $this->netsuite->query($customer_id);
		/* param example [
			'limit' => $this->app->param('limit') ?: 100,
			'offset' => $this->app->param('offset') ?: 0,
		] */
	}

}

?>
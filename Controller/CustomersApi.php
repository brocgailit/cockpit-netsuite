<?php

namespace NetSuite\Controller;

use \LimeExtra\Controller;
use NetSuite\Controller\NetSuiteEndpoint;

class CustomersApi extends Controller {
	private $netsuite;
	private $options;

	public function __construct($options) {
		parent::__construct($options);
		$this->options = $options;
		$config = $this->app['config']['netsuite'];
        $this->netsuite = new NetSuiteEndpoint(
            "https://{$config['account']}.suitetalk.api.netsuite.com/rest/platform/v1/record/customer/",
            [
				'consumer_key'    => $config['consumer_key'],
				'consumer_secret' => $config['consumer_secret'],
				'token'           => $config['token_id'],
				'token_secret'    => $config['token_secret']
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

		return $this->netsuite->query($customer_id, []);
		/* param example [
			'limit' => $this->app->param('limit') ?: 100,
			'offset' => $this->app->param('offset') ?: 0,
		] */
	}

}

?>
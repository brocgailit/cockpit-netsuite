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
        $this->netsuite = new NetSuiteEndpoint(
            "https://{$options['account']}.suitetalk.api.netsuite.com/rest/platform/v1/record/customer",
            [
				'consumer_key'    => $options['consumer_key'],
				'consumer_secret' => $options['consumer_secret'],
				'token'           => $options['token_id'],
				'token_secret'    => $options['token_secret']
			]
        );
    }
    
    public function index() {
		return 'Customers API';
	}

	public function customer($customer_id = '') {
		return $this->options;
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
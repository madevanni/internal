<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

class Partners_model extends MY_Model
{

	private $_client;

	function __construct()
	{
		parent::__construct();
		$this->_client = new Client([
			'base_uri' => 'http://localhost/api/',
			'auth' => ['admin', '1234'],
		]);
	}

	public function get_partners()
    {
        $response = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
}

<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

class Planning_model extends MY_Model
{

    private $_client;

    function __construct()
    {
        parent::__construct();
        $this->_client = new Client([
            'base_uri' => 'http://localhost/api/',
            'auth' => ['admin', '1234'],
            'query' => ['X-API-KEY' => '1234']
        ]);
    }

    public function getItems()
    {
        $response = $this->_client->request('GET', 'items/details', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
}

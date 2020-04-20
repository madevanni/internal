<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

class Sales_model extends MY_Model
{
    /*
     * Infor ERP LN Software Architecture
     * http://www.baanboard.com/node/42
     * tc	Common	master data
     */

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

    public function getPartners() {
        $response = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
    
    public function getModels() {
        $response = $this->_client->request('GET', 'sales/models');

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
}

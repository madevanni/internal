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
            'auth' => ['admin', '1234']
        ]);
    }

    public function getPartners()
    {
        $response = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function getModels()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['rows']) ? intval($_GET['rows']) : 10;

        $response = $this->_client->request('GET', 'sales/models', [
            'query' => [
                'X-API-KEY' => '1234',
                'page' => $page,
                'limit' => $limit
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function saveModel($name)
    {
        $data = [
            'model' => $name,
            'created_by' => $this->auth->user_id(),
            'X-API-KEY' => '1234'
        ];

        $response = $this->_client->request('POST', 'sales/models', [
            'form_params' => $data
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function updateModel($id, $name)
    {
        $data = [
            'id' => $id,
            'name' => $name,
            'modified_by' => $this->auth->user_id(),
            'X-API-KEY' => '1234'
        ];

        $response = $this->_client->request('PUT', 'sales/models', [
            'form_params' => $data
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function deleteModel($id)
    {
        $response = $this->_client->request('DELETE', 'sales/models', [
            'form_params' => [
                'X-API-KEY' => '1234',
                'id' => $id
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }
}

<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Sales_model extends MY_Model {
    /*
     * Infor ERP LN Software Architecture
     * http://www.baanboard.com/node/42
     * tc	Common	master data
     */

    var $API = "";

    function __construct() {
        parent::__construct();
        $this->API = "http://localhost/api/sales";
    }

    function list_partners($id, $limit, $offset) {
        return $this->curl->simple_get($this->API.'/partners', array('id' => $id, 'limit' => $limit, 'offset' => $offset));
    }

    function partner($id) {
        $params = array('id' => $id);
        return json_decode($this->restclient->get($params), true);
    }

//    function save($array) {
//        $this->restclient->post($array);
//    }
//
//    function update($array) {
//        $this->restclient->put($array);
//    }
//
//    function delete($id) {
//        $this->restclient->delete($id);
//    }

}

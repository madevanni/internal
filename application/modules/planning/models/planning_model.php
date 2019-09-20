<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Planning_model extends MY_Model {

    /**
     * Infor ERP LN Software Architecture
     * http://www.baanboard.com/node/42
     * td	Distribution	purchase/sales/inventory control
     * 
     * Business functions are grouped in modules with a three-character code. For instance, the package Distribution (td) consists of the modules:
     * Distribution:Purchase	td pur
     * Distribution:Sales	td sls
     * Distribution:Inventory	td inv
     */
    protected $table_items = 'ttcibd001110';
    protected $meta_table_items = 'Item general meta';
    protected $key_table_pr = 't_item';

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('erplnDB', TRUE);
    }

    public function getItems($rowno, $rowperpage, $search = "") {
        $this->db->select('*');
        $this->db->limit($rowno, $rowperpage);
        $this->db->from($this->table_items);

        if ($search != '') {
            $this->db->where($search);
        }

        $query = $this->db->get();
        $result['countItems'] = $query->num_rows();
        $result['items'] = $query->result();

        return $result;
    }

}

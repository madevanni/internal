<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller {

    protected $permissionCreate = 'Planning.Content.Create';
    protected $permissionDelete = 'Planning.Content.Delete';
    protected $permissionEdit = 'Planning.Content.Edit';
    protected $permissionView = 'Planning.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('planning/planning_model');

        $this->auth->restrict($this->permissionView);
        $this->lang->load('planning');

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_js(array(
            'easyui/jquery.easyui.min.js',
            'easyui/extension/jquery.edatagrid.js'
        ));
        Assets::add_module_js('planning', 'planning.js');
        Assets::add_css(array(
            'easyui/themes/default/easyui.css',
            'easyui/themes/icon.css'
        ));
        Assets::add_module_css('planning', 'planning.css');
    }

    /**
     * Display a list of Forecast data.
     * Using EasyUI 1.8.1
     * with extension edatagrid
     *
     * @return void
     */
    public function forecast() {

        Template::set('forecast');
        Template::set('toolbar_title', 'Planning - Forecast');

        Template::render();
    }

    /**
     * Display a list of Items data.
     * 
     * @return void
     */
    public function items() {
        Template::set('items');
        Template::set('toolbar_title', 'Planning - Items');

        Template::render();
    }

    public function loadItems() {
        $rowno = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rowperpage = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $rowno = ($rowno-1) * $rowperpage;
        $users_data = $this->planning_model->getItems($rowno, $rowperpage, $search);
        $i = 0;
        $rows = array();
        foreach ($users_data['items'] as $row) {
            $rows[$i]['itemid'] = $row->t_item;
            $rows[$i]['itemdesc'] = $row->t_dsca;
            $rows[$i]['itemtype'] = $row->t_kitm;
            $rows[$i]['itemgroup'] = $row->t_citg;
            $rows[$i]['itemunit'] = $row->t_cuni;
            
            $i++;
        }
        
        // Keys total & rows are mandatory for jEasyUI
        $result = array(
            'total' => $users_data['countItems'],
            'rows' => $rows
        );
        echo json_encode($result);
    }

    /**
     * Display a list of Items data.
     * 
     * @return void
     */
    public function bom() {
        Template::set('bom');
        Template::set('toolbar_title', 'Planning - Bill of Materials');

        Template::render();
    }

    /**
     * Create a Planning object.
     *
     * @return void
     */
    public function create() {
        $this->auth->restrict($this->permissionCreate);


        Template::set('toolbar_title', lang('planning_action_create'));

        Template::render();
    }

    /**
     * Allows editing of Planning data.
     *
     * @return void
     */
    public function edit() {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('planning_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/planning');
        }




        Template::set('toolbar_title', lang('planning_edit_heading'));
        Template::render();
    }

}

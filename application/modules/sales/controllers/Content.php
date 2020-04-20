<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Content controller
 */
class Content extends Admin_Controller
{

    protected $permissionCreate = 'Sales.Content.Create';
    protected $permissionDelete = 'Sales.Content.Delete';
    protected $permissionEdit = 'Sales.Content.Edit';
    protected $permissionView = 'Sales.Content.View';

    /**
     * Constructor
     *
     * @return void
     */

    private $_client;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sales/sales_model');

        $this->_client = new Client([
            'base_uri' => 'http://localhost/api/',
            'auth' => ['admin', '1234'],
            'query' => ['X-API-KEY' => '1234']
        ]);

        $this->auth->restrict($this->permissionView);
        $this->lang->load('sales');

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_js(array(
            'jquery.min.js',
            'easyui/jquery.easyui.min.js',
            'easyui/extension/jquery.edatagrid.js'
        ));
        Assets::add_module_js('sales', 'sales.js');
        Assets::add_css(array(
            'easyui/themes/default/easyui.css',
            'asyui/themes/color.css',
            'easyui/themes/icon.css'
        ));
        Assets::add_module_css('sales', 'sales.css');
    }

    /**
     * Display a list of Sales data.
     *
     * @return void
     */
    public function index()
    {

        Template::set('toolbar_title', lang('sales_manage'));
        Template::render();
    }

    /**
     * Create a Sales object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);


        Template::set('toolbar_title', lang('sales_action_create'));

        Template::render();
    }

    /**
     * Allows editing of Sales data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('sales_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/sales');
        }

        Template::set('toolbar_title', lang('sales_edit_heading'));
        Template::render();
    }

    /**
     * Display a list of Business Partners data.
     *
     * @return void
     */
    public function partners()
    {
        Template::set('toolbar_title', 'Business Partners');
        Template::render();
    }

    public function getPartners()
    {
        $response = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        $result = json_encode($response->getBody()->getContents(), true);
        return $result;
    }

    public function projects()
    {
        Template::set('projects');
        Template::set('toolbar_title', 'Sales - Projects');
        Template::render();
    }

    public function getModels()
    {
        $this->output->set_content_type('application/json');
        $models = $this->sales_model->getModels();
        echo json_encode($models['data']);
    }

    public function get_salesOrders()
    {
        /* Default request pager params from jeasyUI */
        $offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $offset = ($offset - 1) * $limit;
        $orders = $this->sales_model->get_orders($offset, $limit, $search);
        $i = 0;
        $rows = array();
        foreach ($orders['data'] as $value) {
            //array of keys = attribute 'field' in view
            $rows[$i]['orno'] = $value->t_orno;
            $rows[$i]['order'] = $value->t_corn;
            $rows[$i]['amount'] = $value->t_oamt;
            $rows[$i]['status'] = $value->t_hdst;
            $rows[$i]['date'] = $value->t_odat;
            $rows[$i]['delivery'] = $value->t_ddat;
            $rows[$i]['type'] = $value->t_sotp;

            $i++;
        }
        $result = array('total' => $orders['countOrders'], 'rows' => $rows);
        echo json_encode($result); //return data json
    }

    public function forecast()
    {
        Template::set('forecast');
        Template::set('toolbar_title', 'Sales - Forecast');

        Template::render();
    }

}

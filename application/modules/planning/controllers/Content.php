<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

/**
 * Content controller
 */
class Content extends Admin_Controller {

    protected $permissionCreate = 'Planning.Content.Create';
    protected $permissionDelete = 'Planning.Content.Delete';
    protected $permissionEdit = 'Planning.Content.Edit';
    protected $permissionView = 'Planning.Content.View';

    private $_client;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->_client = new Client([
            'base_uri' => 'http://localhost/api/',
            'auth' => ['admin', '1234'],
            'query' => ['X-API-KEY' => '1234']
        ]);

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
        Template::set('items', $this->planning_model->getItems());
        Template::set('toolbar_title', 'Planning - Items');
        $response = $this->_client->request('GET', 'items/details', [
            'on_stats' => function (TransferStats $stats) use (&$url) {
                $url = $stats->getEffectiveUri();
            }
        ])->getBody()->getContents();
        Template::set('url', $url);
        Template::render();
    }
    
    public function getItems()
    {
        $result = $this->planning_model->getItems();
        return json_encode($result);
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

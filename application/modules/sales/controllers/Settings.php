<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Settings controller
 */
class Settings extends Admin_Controller
{
    protected $permissionCreate = 'Sales.Settings.Create';
    protected $permissionDelete = 'Sales.Settings.Delete';
    protected $permissionEdit   = 'Sales.Settings.Edit';
    protected $permissionView   = 'Sales.Settings.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->lang->load('sales');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'settings/_sub_nav');

        Assets::add_module_js('sales', 'sales.js');
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

            redirect(SITE_AREA . '/settings/sales');
        }
        
        
        

        Template::set('toolbar_title', lang('sales_edit_heading'));
        Template::render();
    }
}
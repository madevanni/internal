<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Settings controller
 */
class Settings extends Admin_Controller
{
    protected $permissionCreate = 'Planning.Settings.Create';
    protected $permissionDelete = 'Planning.Settings.Delete';
    protected $permissionEdit   = 'Planning.Settings.Edit';
    protected $permissionView   = 'Planning.Settings.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->lang->load('planning');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'settings/_sub_nav');

        Assets::add_module_js('planning', 'planning.js');
    }

    /**
     * Display a list of Planning data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        
    Template::set('toolbar_title', lang('planning_manage'));

        Template::render();
    }
    
    /**
     * Create a Planning object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        

        Template::set('toolbar_title', lang('planning_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Planning data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('planning_invalid_id'), 'error');

            redirect(SITE_AREA . '/settings/planning');
        }
        
        
        

        Template::set('toolbar_title', lang('planning_edit_heading'));
        Template::render();
    }
}
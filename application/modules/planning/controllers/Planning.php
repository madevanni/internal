<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Planning controller
 */
class Planning extends Front_Controller
{
    protected $permissionCreate = 'Planning.Planning.Create';
    protected $permissionDelete = 'Planning.Planning.Delete';
    protected $permissionEdit   = 'Planning.Planning.Edit';
    protected $permissionView   = 'Planning.Planning.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->lang->load('planning');
        
        

        Assets::add_module_js('planning', 'planning.js');
    }

    /**
     * Display a list of Planning data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        

        Template::render();
    }
    
}
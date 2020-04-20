<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Sales controller
 */
class Sales extends Front_Controller
{
    protected $permissionCreate = 'Sales.Sales.Create';
    protected $permissionDelete = 'Sales.Sales.Delete';
    protected $permissionEdit   = 'Sales.Sales.Edit';
    protected $permissionView   = 'Sales.Sales.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->lang->load('sales');
        
        Assets::add_module_js('sales', 'sales.js');
    }

    /**
     * Display a list of Sales data.
     *
     * @return void
     */
    public function index()
    {
        
        Template::render();
    }
    
}
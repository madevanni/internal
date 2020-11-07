<?php defined('BASEPATH') || exit('No direct script access allowed');

class Forecast_model extends BF_Model
{
    protected $table_name	= 'forecast';
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= true;
	protected $set_created	= true;
	protected $set_modified = true;
	protected $soft_deletes	= true;

	protected $created_field     = 'created_on';
    protected $created_by_field  = 'created_by';
	protected $modified_field    = 'modified_on';
    protected $modified_by_field = 'modified_by';
    protected $deleted_field     = 'deleted';
    protected $deleted_by_field  = 'deleted_by';

	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'bp_id',
			'label' => 'lang:forecast_field_bp_id',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'model_id',
			'label' => 'lang:forecast_field_model_id',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'item_id',
			'label' => 'lang:forecast_field_item_id',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'cust_part',
			'label' => 'lang:forecast_field_cust_part',
			'rules' => 'max_length[255]',
		),
		array(
			'field' => 'fy',
			'label' => 'lang:forecast_field_fy',
			'rules' => 'max_length[4]',
		),
		array(
			'field' => 'period',
			'label' => 'lang:forecast_field_period',
			'rules' => 'max_length[2]',
		),
		array(
			'field' => 'sales_qty',
			'label' => 'lang:forecast_field_sales_qty',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'inv_qty',
			'label' => 'lang:forecast_field_inv_qty',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'prod_qty',
			'label' => 'lang:forecast_field_prod_qty',
			'rules' => 'max_length[11]',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function delete_forecast($pid) {

    	$ch = curl_init();
		$inputan['kode_aplikasi'] = $this->config->item("kode_aplikasi");
		$inputan['id'] = $pid;
		$inputan['user_id'] = $this->session->userdata("user_id");
		$jsoninputan = json_encode($inputan);
		curl_setopt($ch, CURLOPT_URL,$this->config->item("url_induk")."sales/forecast/delete");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"data=".$jsoninputan);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$hasil = curl_exec($ch);
		curl_close ($ch);

		echo "<pre>";
		print_r ($hasil);
		echo "</pre>";
		echo "<h1>lorem ipsum dolor si amet</h1>";
    }
}
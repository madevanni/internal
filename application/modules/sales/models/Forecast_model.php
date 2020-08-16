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
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'model_id',
			'label' => 'lang:forecast_field_model_id',
			'rules' => 'required|max_length[11]',
		),
		array(
			'field' => 'item_id',
			'label' => 'lang:forecast_field_item_id',
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'fy',
			'label' => 'lang:forecast_field_fy',
			'rules' => 'required|max_length[255]',
		),
		array(
			'field' => 'p_one',
			'label' => 'lang:forecast_field_p_one',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'p_two',
			'label' => 'lang:forecast_field_p_two',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'p_three',
			'label' => 'lang:forecast_field_p_three',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'p_four',
			'label' => 'lang:forecast_field_p_four',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'p_five',
			'label' => 'lang:forecast_field_p_five',
			'rules' => '',
		),
		array(
			'field' => 'p_six',
			'label' => 'lang:forecast_field_p_six',
			'rules' => '',
		),
		array(
			'field' => 'p_seven',
			'label' => 'lang:forecast_field_p_seven',
			'rules' => '',
		),
		array(
			'field' => 'p_eight',
			'label' => 'lang:forecast_field_p_eight',
			'rules' => '',
		),
		array(
			'field' => 'p_nine',
			'label' => 'lang:forecast_field_p_nine',
			'rules' => '',
		),
		array(
			'field' => 'p_ten',
			'label' => 'lang:forecast_field_p_ten',
			'rules' => '',
		),
		array(
			'field' => 'p_eleven',
			'label' => 'lang:forecast_field_p_eleven',
			'rules' => '',
		),
		array(
			'field' => 'p_twelve',
			'label' => 'lang:forecast_field_p_twelve',
			'rules' => '',
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
}
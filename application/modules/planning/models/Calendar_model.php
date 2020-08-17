<?php defined('BASEPATH') || exit('No direct script access allowed');

class Calendar_model extends BF_Model
{
    protected $table_name	= 'time_dimension';
	protected $key			= 'db_date';
	protected $date_format	= 'datetime';

	protected $log_user 	= false;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= false;


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
			'field' => 'db_date',
			'label' => 'lang:calendar_field_db_date',
			'rules' => '',
		),
		array(
			'field' => 'year',
			'label' => 'lang:calendar_field_year',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'month',
			'label' => 'lang:calendar_field_month',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'day',
			'label' => 'lang:calendar_field_day',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'quarter',
			'label' => 'lang:calendar_field_quarter',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'week',
			'label' => 'lang:calendar_field_week',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'day_name',
			'label' => 'lang:calendar_field_day_name',
			'rules' => 'max_length[9]',
		),
		array(
			'field' => 'month_name',
			'label' => 'lang:calendar_field_month_name',
			'rules' => 'max_length[9]',
		),
		array(
			'field' => 'holiday_flag',
			'label' => 'lang:calendar_field_holiday_flag',
			'rules' => 'max_length[1]',
		),
		array(
			'field' => 'weekend_flag',
			'label' => 'lang:calendar_field_weekend_flag',
			'rules' => 'max_length[1]',
		),
		array(
			'field' => 'event',
			'label' => 'lang:calendar_field_event',
			'rules' => 'max_length[50]',
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
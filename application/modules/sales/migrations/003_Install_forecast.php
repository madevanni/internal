<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_forecast extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'forecast';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'bp_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ),
        'model_id' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
        ),
        'item_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ),
        'cust_part' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ),
        'fy' => array(
            'type'       => 'VARCHAR',
            'constraint' => 4,
            'null'       => true,
        ),
        'period' => array(
            'type'       => 'INT',
            'constraint' => 2,
            'null'       => true,
        ),
        'sales_qty' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
        ),
        'inv_qty' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
            'default'    => '0'
        ),
        'inv_date' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'prod_qty' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
            'default'    => '0'
        ),
        'deleted' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => '0',
        ),
        'deleted_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'created_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
        'modified_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'modified_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}
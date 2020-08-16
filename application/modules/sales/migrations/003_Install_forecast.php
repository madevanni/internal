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
            'null'       => false,
        ),
        'model_id' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
        ),
        'item_id' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'fy' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'p_one' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_two' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_three' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_four' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_five' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_six' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_seven' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_eight' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_nine' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_ten' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_eleven' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
        ),
        'p_twelve' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0
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
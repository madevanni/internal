<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_planning_permissions extends Migration {

    /**
     * @var array Permissions to Migrate
     */
    private $permissionValues = array(
        array(
            'name' => 'Planning.Content.View',
            'description' => 'View Planning Content',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Content.Create',
            'description' => 'Create Planning Content',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Content.Edit',
            'description' => 'Edit Planning Content',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Content.Delete',
            'description' => 'Delete Planning Content',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Reports.View',
            'description' => 'View Planning Reports',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Reports.Create',
            'description' => 'Create Planning Reports',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Reports.Edit',
            'description' => 'Edit Planning Reports',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Reports.Delete',
            'description' => 'Delete Planning Reports',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Settings.View',
            'description' => 'View Planning Settings',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Settings.Create',
            'description' => 'Create Planning Settings',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Settings.Edit',
            'description' => 'Edit Planning Settings',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Settings.Delete',
            'description' => 'Delete Planning Settings',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Developer.View',
            'description' => 'View Planning Developer',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Developer.Create',
            'description' => 'Create Planning Developer',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Developer.Edit',
            'description' => 'Edit Planning Developer',
            'status' => 'active',
        ),
        array(
            'name' => 'Planning.Developer.Delete',
            'description' => 'Delete Planning Developer',
            'status' => 'active',
        ),
    );

    /**
     * @var string The name of the permission key in the role_permissions table
     */
    private $permissionKey = 'permission_id';

    /**
     * @var string The name of the permission name field in the permissions table
     */
    private $permissionNameField = 'name';

    /**
     * @var string The name of the role/permissions ref table
     */
    private $rolePermissionsTable = 'role_permissions';

    /**
     * @var numeric The role id to which the permissions will be applied
     */
    private $roleId = '1';

    /**
     * @var string The name of the role key in the role_permissions table
     */
    private $roleKey = 'role_id';

    /**
     * @var string The name of the permissions table
     */
    private $tableName = 'permissions';

    //--------------------------------------------------------------------

    /**
     * Install this version
     *
     * @return void
     */
    public function up() {
        $this->load->dbforge();

        $this->dbforge->add_field('forecast_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY');
        $this->dbforge->add_field('model VARCHAR(255) NOT NULL');
        $this->dbforge->add_field('psi_number VARCHAR(255) NOT NULL');
        $this->dbforge->add_field('cust_number VARCHAR(255) NULL');
        $this->dbforge->add_field('sales_qty INT(11) NULL');
        $this->dbforge->add_field('period TINYINT(3) NULL');
        $this->dbforge->add_field('date DATETIME NOT NULL');

        $this->dbforge->create_table('erp_forecast');

        $rolePermissionsData = array();
        foreach ($this->permissionValues as $permissionValue) {
            $this->db->insert($this->tableName, $permissionValue);

            $rolePermissionsData[] = array(
                $this->roleKey => $this->roleId,
                $this->permissionKey => $this->db->insert_id(),
            );
        }

        $this->db->insert_batch($this->rolePermissionsTable, $rolePermissionsData);
    }

    /**
     * Uninstall this version
     *
     * @return void
     */
    public function down() {
        $this->load->dbforge();

        $this->dbforge->drop_table('erp_forecast');
        
        $permissionNames = array();
        foreach ($this->permissionValues as $permissionValue) {
            $permissionNames[] = $permissionValue[$this->permissionNameField];
        }

        $query = $this->db->select($this->permissionKey)
                ->where_in($this->permissionNameField, $permissionNames)
                ->get($this->tableName);

        if (!$query->num_rows()) {
            return;
        }

        $permissionIds = array();
        foreach ($query->result() as $row) {
            $permissionIds[] = $row->{$this->permissionKey};
        }

        $this->db->where_in($this->permissionKey, $permissionIds)
                ->delete($this->rolePermissionsTable);

        $this->db->where_in($this->permissionNameField, $permissionNames)
                ->delete($this->tableName);
    }

}

<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_sales_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Sales.Content.View',
			'description' => 'View Sales Content',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Content.Create',
			'description' => 'Create Sales Content',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Content.Edit',
			'description' => 'Edit Sales Content',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Content.Delete',
			'description' => 'Delete Sales Content',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Reports.View',
			'description' => 'View Sales Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Reports.Create',
			'description' => 'Create Sales Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Reports.Edit',
			'description' => 'Edit Sales Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Reports.Delete',
			'description' => 'Delete Sales Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Settings.View',
			'description' => 'View Sales Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Settings.Create',
			'description' => 'Create Sales Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Settings.Edit',
			'description' => 'Edit Sales Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Settings.Delete',
			'description' => 'Delete Sales Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Developer.View',
			'description' => 'View Sales Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Developer.Create',
			'description' => 'Create Sales Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Developer.Edit',
			'description' => 'Edit Sales Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Sales.Developer.Delete',
			'description' => 'Delete Sales Developer',
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
	public function up()
	{
		$rolePermissionsData = array();
		foreach ($this->permissionValues as $permissionValue) {
			$this->db->insert($this->tableName, $permissionValue);

			$rolePermissionsData[] = array(
                $this->roleKey       => $this->roleId,
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
	public function down()
	{
        $permissionNames = array();
		foreach ($this->permissionValues as $permissionValue) {
            $permissionNames[] = $permissionValue[$this->permissionNameField];
        }

        $query = $this->db->select($this->permissionKey)
                          ->where_in($this->permissionNameField, $permissionNames)
                          ->get($this->tableName);

        if ( ! $query->num_rows()) {
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
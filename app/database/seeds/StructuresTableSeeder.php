<?php

class StructuresTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('structures')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'clients', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'name' => 'activities', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'name' => 'activitiesemployees', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'name' => 'activitiespositions', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'name' => 'activitiesprocesses', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'name' => 'addresses', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'name' => 'businesses', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'name' => 'campaigns', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 10, 'name' => 'categoriesparameters', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 11, 'name' => 'cities', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 12, 'name' => 'colors', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 13, 'name' => 'contacts', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 14, 'name' => 'contactscustomers', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 18, 'name' => 'customers', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 19, 'name' => 'databases', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 20, 'name' => 'departments', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 21, 'name' => 'employees', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 22, 'name' => 'employeescampaigns', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 24, 'name' => 'events', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 25, 'name' => 'groups', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 26, 'name' => 'instancelogs', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 27, 'name' => 'instances', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 28, 'name' => 'levels', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 29, 'name' => 'locations', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 30, 'name' => 'menuitems', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 31, 'name' => 'metadatas', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 32, 'name' => 'metafields', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 33, 'name' => 'migrations', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 34, 'name' => 'options', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 35, 'name' => 'orders', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 36, 'name' => 'ordersdetails', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 37, 'name' => 'organizationparameters', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 38, 'name' => 'organizations', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 39, 'name' => 'parameters', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 40, 'name' => 'password_reminders', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 41, 'name' => 'positions', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 42, 'name' => 'processes', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 43, 'name' => 'recoveryquestions', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 44, 'name' => 'roles', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 45, 'name' => 'rolesgroups', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 46, 'name' => 'rolesoptions', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 47, 'name' => 'rules', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 48, 'name' => 'states', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 49, 'name' => 'statusaddresses', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 50, 'name' => 'statuscustomers', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 51, 'name' => 'statusemployees', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 52, 'name' => 'statuslocations', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 53, 'name' => 'statusorders', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 54, 'name' => 'statustasks', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 55, 'name' => 'structures', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 56, 'name' => 'tasks', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 57, 'name' => 'teams', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 58, 'name' => 'typesactivities', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 59, 'name' => 'typesaddresses', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 60, 'name' => 'typescustomers', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 61, 'name' => 'typesfields', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 62, 'name' => 'typesnotifications', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 63, 'name' => 'typesorders', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 64, 'name' => 'typesprocesses', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 65, 'name' => 'unitsmeasures', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 66, 'name' => 'userparameters', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 67, 'name' => 'users', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 68, 'name' => 'usersgroups', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 69, 'name' => 'usersroles', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 70, 'name' => 'counties', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 71, 'name' => 'countries', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 72, 'name' => 'currencies', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 73, 'name' => 'applications', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 79, 'name' => 'datatypes', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 80, 'name' => 'fields', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 81, 'name' => 'fieldsapplications', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 82, 'name' => 'objections', 'isVisible' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 83, 'name' => 'typesapplications', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 84, 'name' => 'typesassignments', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 86, 'name' => 'activitiesdepartments', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 87, 'name' => 'activitieslevels', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 88, 'name' => 'statusinstances', 'isVisible' => 0, 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('structures')->insert($data);
	}

}

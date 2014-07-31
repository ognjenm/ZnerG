<?php

class OptionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('options')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'Databases', 'description' => '', 'link' => 'databases', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'Options', 'description' => '', 'link' => 'options', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'name' => 'Categories of Parameters', 'description' => '', 'link' => 'categoryParameters', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'name' => 'Businesses', 'description' => '', 'link' => 'businesses', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'name' => 'Organizations', 'description' => '', 'link' => 'organizations', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'name' => 'Parameters', 'description' => '', 'link' => 'parameters', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'name' => 'Currencies', 'description' => '', 'link' => 'currencies', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'name' => 'Countries', 'description' => '', 'link' => 'countries', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'name' => 'Recovery Questions', 'description' => '', 'link' => 'recoveryQuestions', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 10, 'name' => 'Status for Tasks', 'description' => '', 'link' => 'statusTasks', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 11, 'name' => 'Status for Locations', 'description' => '', 'link' => 'statusLocations', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 12, 'name' => 'Status for Employees', 'description' => '', 'link' => 'statusEmployees', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 13, 'name' => 'Status for Addresses', 'description' => '', 'link' => 'statusAddresses', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 14, 'name' => 'Types of Addresses', 'description' => '', 'link' => 'typesAddresses', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 15, 'name' => 'Types of Activities', 'description' => '', 'link' => 'typesActivities', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 16, 'name' => 'Types of Fields', 'description' => '', 'link' => 'typesFields', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 17, 'name' => 'Types of Notifications', 'description' => '', 'link' => 'typesNotifications', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 18, 'name' => 'Types of Processes', 'description' => '', 'link' => 'typesProcesses', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 19, 'name' => 'Teams', 'description' => '', 'link' => 'teams', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 20, 'name' => 'Colors', 'description' => '', 'link' => 'colors', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 21, 'name' => 'Units of Measures', 'description' => '', 'link' => 'unitsMeasures', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 22, 'name' => 'Levels', 'description' => '', 'link' => 'levels', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 23, 'name' => 'Groups', 'description' => '', 'link' => 'groups', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 24, 'name' => 'Menu Items', 'description' => '', 'link' => 'menuItems', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 25, 'name' => 'Roles', 'description' => '', 'link' => 'roles', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 26, 'name' => 'States', 'description' => '', 'link' => 'states', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 27, 'name' => 'Positions', 'description' => '', 'link' => 'positions', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 28, 'name' => 'Processes', 'description' => '', 'link' => 'processes', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 29, 'name' => 'Activities', 'description' => '', 'link' => 'activities', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 30, 'name' => 'Cities', 'description' => '', 'link' => 'cities', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 31, 'name' => 'Counties', 'description' => '', 'link' => 'counties', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 32, 'name' => 'Clients', 'description' => '', 'link' => 'clients', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 33, 'name' => 'Employees', 'description' => '', 'link' => 'employees', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 34, 'name' => 'Campaigns', 'description' => '', 'link' => 'campaigns', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 35, 'name' => 'Departments', 'description' => '', 'link' => 'departments', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 36, 'name' => 'Users', 'description' => '', 'link' => 'users', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 37, 'name' => 'Types of Customers', 'description' => '', 'link' => 'typesCustomers', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 38, 'name' => 'Types of Orders', 'description' => '', 'link' => 'typesOrders', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 39, 'name' => 'Events', 'description' => '', 'link' => 'events', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 40, 'name' => 'Status for Customers', 'description' => '', 'link' => 'statusCustomers', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 41, 'name' => 'Status for Orders', 'description' => '', 'link' => 'statusOrders', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 42, 'name' => 'Meta data', 'description' => '', 'link' => 'metaDatas', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 43, 'name' => 'Configuration for administrators', 'description' => '', 'link' => 'organizationParameters', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 44, 'name' => 'Configuration for users', 'description' => '', 'link' => 'userParameters', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 45, 'name' => 'Main', 'description' => '', 'link' => 'main', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 46, 'name' => 'Tasks', 'description' => '', 'link' => 'tasks', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 47, 'name' => 'Structures', 'description' => '', 'link' => 'structures', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 48, 'name' => 'Fields', 'description' => '', 'link' => 'fields', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 49, 'name' => 'Applications', 'description' => '', 'link' => 'applications', 'version' => '0.9', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 50, 'name' => 'Workflow', 'description' => '', 'link' => 'workflow', 'version' => '0.1', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('options')->insert($data);
	}

}

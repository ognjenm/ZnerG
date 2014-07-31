<?php

// This is not updated!!!

class MenuItemsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('menuItems')->truncate();
		$data = array(
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Home', 'position' => '100', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 45, 'name' => 'Main', 'position' => '110', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'To-do list', 'position' => '115', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Calendar', 'position' => '120', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 46, 'name' => 'Tasks', 'position' => '150', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Sales', 'position' => '200', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 32, 'name' => 'Clients', 'position' => '210', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 34, 'name' => 'Campaigns', 'position' => '220', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 19, 'name' => 'Teams', 'position' => '230', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 4, 'name' => 'Businesses', 'position' => '240', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 39, 'name' => 'Events', 'position' => '245', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => '-', 'position' => '250', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 37, 'name' => 'Types of customers', 'position' => '260', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 38, 'name' => 'Types of orders', 'position' => '270', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 40, 'name' => 'Status for customers', 'position' => '280', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 41, 'name' => 'Status for orders', 'position' => '290', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Reports', 'position' => '300', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Documents', 'position' => '400', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Workflow', 'position' => '500', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 28, 'name' => 'Processes', 'position' => '510', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 29, 'name' => 'Activities', 'position' => '520', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 42, 'name' => 'Meta data', 'position' => '530', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 48, 'name' => 'Fields', 'position' => '540', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 49, 'name' => 'Applications', 'position' => '550', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 50, 'name' => 'Workflow definition', 'position' => '560', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Configuration', 'position' => '600', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 10, 'name' => 'Status for tasks', 'position' => '605', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 11, 'name' => 'Status for locations', 'position' => '610', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 12, 'name' => 'Status for employees', 'position' => '615', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 13, 'name' => 'Status for addresses', 'position' => '620', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => '-', 'position' => '625', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 14, 'name' => 'Types of addresses', 'position' => '630', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 15, 'name' => 'Types of activities', 'position' => '635', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 16, 'name' => 'Types of fields', 'position' => '640', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 17, 'name' => 'Types of notifications', 'position' => '645', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 18, 'name' => 'Types of processes', 'position' => '650', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 3, 'name' => 'Types of parameters', 'position' => '655', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => '-', 'position' => '660', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 20, 'name' => 'Colors', 'position' => '665', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 7, 'name' => 'Currencies', 'position' => '670', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 9, 'name' => 'Recovery questions', 'position' => '675', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 21, 'name' => 'Units of Measures', 'position' => '680', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => '-', 'position' => '685', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 8, 'name' => 'Countries', 'position' => '690', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 26, 'name' => 'States', 'position' => '692', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 31, 'name' => 'Counties', 'position' => '694', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 30, 'name' => 'Cities', 'position' => '696', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Organization', 'position' => '700', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 33, 'name' => 'Employees', 'position' => '710', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 27, 'name' => 'Positions', 'position' => '510', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 35, 'name' => 'Departments', 'position' => '720', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 22, 'name' => 'Levels', 'position' => '740', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'Administration', 'position' => '800', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 23, 'name' => 'Groups', 'position' => '810', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 24, 'name' => 'Menu items', 'position' => '820', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 25, 'name' => 'Roles', 'position' => '830', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 36, 'name' => 'Users', 'position' => '840', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 43, 'name' => 'Configuration', 'position' => '850', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 44, 'name' => 'Customization', 'position' => '860', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => null, 'name' => 'System', 'position' => '900', 'level' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 1, 'name' => 'Databases', 'position' => '910', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 47, 'name' => 'Structures', 'position' => '915', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 2, 'name' => 'Menu options', 'position' => '920', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 5, 'name' => 'Organizations', 'position' => '930', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id_organization' => 1, 'id_option' => 6, 'name' => 'Parameters', 'position' => '940', 'level' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('menuItems')->insert($data);
	}

}


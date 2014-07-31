<?php

class ParametersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('parameters')->truncate();

		$data = array(
			array('id' => 1, 'name' => 'titleApp', 'description' => 'Title of the application', 'value' => 'ZnerG Inc.', 'access' => 'System', 'id_category' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'name' => 'language', 'description' => 'Language of the application', 'value' => 'en', 'access' => 'User', 'id_category' => '1', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'name' => 'menuDefault', 'description' => 'Yes if you want to use the default menu', 'value' => 'Yes', 'access' => 'Organization', 'id_category' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'name' => 'totalAccessAdmin', 'description' => 'Yes if you want access to all options available', 'value' => 'No', 'access' => 'System', 'id_category' => '5', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'name' => 'inmediateMenuUpdate', 'description' => 'Yes if you want updated instantly every change to the parameters', 'value' => 'Yes', 'access' => 'Organization', 'id_category' => '3', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'name' => 'copyrightYear', 'description' => 'Year for the Copyright', 'value' => '2014', 'access' => 'System', 'id_category' => '5', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'name' => 'inheritParentData', 'description' => 'This variable is Yes when you want to use the definitions provided by your parent organizations\r\nIf set to No, your own information will be used\r\n', 'value' => 'Yes', 'access' => 'Organization', 'id_category' => '4', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'name' => 'stateDefault', 'description' => 'Default state\r\nIf set to No, your own information will be used\r\n', 'value' => '1', 'access' => 'User', 'id_category' => '5', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'name' => 'maxAutocompleteRows', 'description' => 'Max number of rows for the autocomplete control\r\n', 'value' => '25', 'access' => 'Organization', 'id_category' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 10, 'name' => 'minCharactersAutocomplete', 'description' => 'Minimum number of characters needed to enter before the autocomplete control starts working\r\n', 'value' => '2', 'access' => 'System', 'id_category' => '2', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('parameters')->insert($data);
	}

}
 	 
<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('users')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '1', 'id_employee' => NULL,'username' => 'admin@znerg.com', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'admin@znerg.com', 'isActive' => 'Yes', 'id_recoveryQuestion' => '1', 'answer' => '', 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => '2', 'id_employee' => NULL, 'username' => 'admin@cydcor.com', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'admin@cydcor.com', 'isActive' => 'Yes', 'id_recoveryQuestion' => '2', 'answer' => '', 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => '3', 'id_employee' => NULL, 'username' => 'admin@dmcatlanta.com', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'admin@7marketing.com', 'isActive' => 'Yes', 'id_recoveryQuestion' => '2', 'answer' => '', 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => '4', 'id_employee' => NULL, 'username' => 'admin@evantage.net', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'admin@evantage.net', 'isActive' => 'Yes', 'id_recoveryQuestion' => '2', 'answer' => '', 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => '3', 'id_employee' => NULL, 'username' => 'admin@7marketing.com', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'admin@7marketing.com', 'isActive' => 'Yes', 'id_recoveryQuestion' => '2', 'answer' => '', 'isSystem' => 'Yes', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => '4', 'id_employee' => 1, 'username' => 'chris@evantage.net', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'chris@evantage.net', 'isActive' => 'Yes', 'id_recoveryQuestion' => '3', 'answer' => '', 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'id_organization' => '4', 'id_employee' => 5, 'username' => 'eduardo@evantage.net', 'password' => '$2y$08$Njl/9TFTQXIlpbUnZLed7.yMCZROyv6DEDmgRh8j877GxjmvanpsS', 'email' => 'eduardo@evantage.net', 'isActive' => 'Yes', 'id_recoveryQuestion' => '4', 'answer' => '', 'isSystem' => 'No', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('users')->insert($data);
	}

}


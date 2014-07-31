<?php

class RecoveryQuestionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		//DB::table('recoveryQuestions')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => '1', 'question' => 'What was your childhood nickname?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => '1', 'question' => 'In what city did you meet your spouse/significant other?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => '1', 'question' => 'What is the name of your favorite childhood friend?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => '1', 'question' => 'What street did you live on in third grade?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => '1', 'question' => 'What is your oldest sibling’s birthday month and year?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => '1', 'question' => 'What is the middle name of your oldest child?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 7, 'id_organization' => '1', 'question' => 'What is your oldest sibling\'s middle name?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 8, 'id_organization' => '1', 'question' => 'What school did you attend for sixth grade?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 9, 'id_organization' => '1', 'question' => 'What is your oldest cousin\'s first and last name?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 10, 'id_organization' => '1', 'question' => 'In what city or town did your mother and father meet?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 11, 'id_organization' => '1', 'question' => 'What was the last name of your third grade teacher?', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 12, 'id_organization' => '1', 'question' => 'In what city or town was your first job?', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('recoveryQuestions')->insert($data);
	}

}

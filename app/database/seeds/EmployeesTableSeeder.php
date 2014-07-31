<?php

class EmployeesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('employees')->truncate();

		$data = array(
			array('id' => 1, 'id_organization' => 4, 'id_position' => 1, 'id_department' => 1, 'id_employeeToReport' => null, 'id_statusEmployee' => 1, 'firstName' => 'Chris', 'lastName' => 'Auwarter', 'startDate' => '2008-11-13', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 2, 'id_organization' => 4, 'id_position' => 2, 'id_department' => 1, 'id_employeeToReport' => 1, 'id_statusEmployee' => 1, 'firstName' => 'Preston', 'lastName' => 'Schwab', 'startDate' => '2010-10-07', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 3, 'id_organization' => 4, 'id_position' => 2, 'id_department' => 1, 'id_employeeToReport' => 1, 'id_statusEmployee' => 1, 'firstName' => 'Jacob', 'lastName' => 'Shackleford', 'startDate' => '2011-12-21', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 4, 'id_organization' => 4, 'id_position' => 4, 'id_department' => 2, 'id_employeeToReport' => 1, 'id_statusEmployee' => 1, 'firstName' => 'Patrick', 'lastName' => 'Lee', 'startDate' => '2012-08-01', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 5, 'id_organization' => 4, 'id_position' => 4, 'id_department' => 2, 'id_employeeToReport' => 1, 'id_statusEmployee' => 1, 'firstName' => 'Eduardo', 'lastName' => 'Garcia', 'startDate' => '2013-09-01', 'created_at' => new DateTime, 'updated_at' => new DateTime),
			array('id' => 6, 'id_organization' => 4, 'id_position' => 4, 'id_department' => 2, 'id_employeeToReport' => 1, 'id_statusEmployee' => 1, 'firstName' => 'Gareth', 'lastName' => 'Roberts', 'startDate' => '2013-12-28', 'created_at' => new DateTime, 'updated_at' => new DateTime
		));

		// Uncomment the below to run the seeder
		DB::table('employees')->insert($data);
	}

}


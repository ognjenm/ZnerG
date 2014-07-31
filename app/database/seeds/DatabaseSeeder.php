<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		//$this->call('DatabasesTableSeeder');
		//$this->call('DatatypesTableSeeder');

		// This table load information by code
		// $this->call('StructuresTableSeeder');

		// This table is so extense that is better to migrate using SQL script
		//$this->call('OptionsTableSeeder');

		//$this->call('CategoriesParametersTableSeeder');
		//$this->call('BusinessesTableSeeder');
		//$this->call('OrganizationsTableSeeder');
		//$this->call('ParametersTableSeeder');
		//$this->call('MetaDatasTableSeeder');
		//$this->call('CurrenciesTableSeeder');
		//$this->call('CountriesTableSeeder');
		//$this->call('RecoveryQuestionsTableSeeder');
		//$this->call('StatusLocationsTableSeeder');
		//$this->call('StatusEmployeesTableSeeder');
		//$this->call('StatusAddressesTableSeeder');
		//$this->call('TypesActivitiesTableSeeder');
		//$this->call('TypesAddressesTableSeeder');
		//$this->call('TypesApplicationsTableSeeder');
		//$this->call('TypesAssignmentsTableSeeder');
		//$this->call('TypesFieldsTableSeeder');
		//$this->call('TypesNotificationsTableSeeder');
		//$this->call('TypesProcessesTableSeeder');
		//$this->call('TeamsTableSeeder');
		//$this->call('ColorsTableSeeder');
		//$this->call('UnitsMeasuresTableSeeder');
		//$this->call('LevelsTableSeeder');
		//$this->call('GroupsTableSeeder');

		// This table is so extense that is better to migrate using SQL script
		// $this->call('MenuItemsTableSeeder');

		//$this->call('RolesTableSeeder');

		//$this->call('StatesTableSeeder');
		//$this->call('PositionsTableSeeder');

		// $this->call('ApplicationsTableSeeder');
		//$this->call('CitiesTableSeeder');
		//$this->call('CountiesTableSeeder');
		// $this->call('AddressesTableSeeder');
		//$this->call('ClientsTableSeeder');
		// $this->call('LocationsTableSeeder');
		//$this->call('DepartmentsTableSeeder');
		//$this->call('EmployeesTableSeeder');
		//$this->call('CampaignsTableSeeder');
		// $this->call('ContactsTableSeeder');
		
		//$this->call('UsersTableSeeder');

		// This table is so extense that is better to migrate using SQL script
		// $this->call('ObjectionsTableSeeder');

		//$this->call('TypesCustomersTableSeeder');
		//$this->call('TypesOrdersTableSeeder');
		//$this->call('EventsTableSeeder');
		//$this->call('StatusCustomersTableSeeder');

		//$this->call('StatusInstancesTableSeeder');
		//$this->call('StatusTasksTableSeeder');
		//$this->call('StatusOrdersTableSeeder');

		// $this->call('EmployeesCampaignsTableSeeder');
		//$this->call('ActivitiesTableSeeder');
		//$this->call('ProcessesTableSeeder');
		//$this->call('ActivitiesProcessesTableSeeder');
		// $this->call('CustomersTableSeeder');
		// $this->call('RulesTableSeeder');

		// Fields is to too extense so it is better to migrate using SQL script
		// $this->call('FieldsTableSeeder');
	}
}

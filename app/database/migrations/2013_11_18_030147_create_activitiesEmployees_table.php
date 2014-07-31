<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activitiesEmployees', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_activitiesProcess');
			$table->unsignedInteger('id_employee');
			$table->primary(array('id_activitiesProcess', 'id_employee'));
			$table->foreign('id_activitiesProcess')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_employee')->references('id')->on('employees')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activitiesEmployees');
	}

}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->unsignedInteger('id_position');
			$table->unsignedInteger('id_department');
			$table->unsignedInteger('id_employeeToReport')->nullable();
			$table->unsignedInteger('id_address')->nullable();
			$table->unsignedInteger('id_statusEmployee');
			$table->string('alternativeId',12)->nullable();
			$table->string('firstName',16);
			$table->string('lastName',16);
			$table->string('driverLicense',10)->nullable();
			$table->date('dateOfBirth')->nullable();
			$table->date('startDate');
			$table->date('endDate')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('restrict');
			$table->foreign('id_position')->references('id')->on('positions')->onDelete('restrict');
			$table->foreign('id_address')->references('id')->on('addresses')->onDelete('restrict');
			$table->foreign('id_statusEmployee')->references('id')->on('statusEmployees')->onDelete('restrict');
		});

		Schema::table('employees', function(Blueprint $table) {
			$table->foreign('id_employeeToReport')->references('id')->on('employees')->onDelete('restrict');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employees');
	}

}
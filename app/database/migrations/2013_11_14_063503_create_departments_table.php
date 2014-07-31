<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departments', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->unsignedInteger('id_departmentSuperior')->nullable();
			$table->unsignedInteger('id_employeeResponsible')->nullable();
			$table->string('name',32);
			$table->string('description', 256)->nullable();
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('restrict');
			$table->foreign('id_departmentSuperior')->references('id')->on('departments')->onDelete('set null');
			$table->foreign('id_employeeResponsible')->references('id')->on('employees')->onDelete('set null');
		});

		Schema::table('employees', function(Blueprint $table) {
			$table->foreign('id_department')->references('id')->on('departments')->onDelete('restrict');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('departments');
	}

}
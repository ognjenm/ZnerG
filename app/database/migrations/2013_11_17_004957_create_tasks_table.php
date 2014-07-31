<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_activitiesProcess');
			$table->unsignedInteger('id_instance');
			$table->unsignedInteger('id_employee');
			$table->unsignedInteger('id_statusTask');
			$table->datetime('expirationDate')->nullable();
			$table->datetime('dueDate')->nullable();
			$table->enum('isAppointment', array('Yes', 'No'))->default('No');
			$table->integer('duration')->nullable();
			$table->text('notes')->nullable();
			$table->text('summary')->nullable();
			$table->text('reference')->nullable();
			$table->enum('isActive', array('No', 'Yes'))->default('Yes');
			$table->foreign('id_activitiesProcess')->references('id')->on('activitiesProcesses')->onDelete('cascade');
			$table->foreign('id_instance')->references('id')->on('instances')->onDelete('cascade');
			$table->foreign('id_employee')->references('id')->on('employees')->onDelete('restrict');
			$table->foreign('id_statusTask')->references('id')->on('statusTasks')->onDelete('restrict');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tasks');
	}

}
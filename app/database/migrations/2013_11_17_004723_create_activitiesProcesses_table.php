<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesProcessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activitiesProcesses', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_process');
			$table->unsignedInteger('id_activity');
			$table->unsignedInteger('id_typesStart');
			$table->unsignedInteger('id_typesEnd');
			$table->unsignedInteger('id_typesAssignment');
			$table->unsignedInteger('id_typesNotification');
			$table->string('name',64);
			$table->enum('sendNotification', array('Yes', 'No'))->default('No');
			$table->enum('sendToSupervisor', array('Yes', 'No'))->default('No');
			$table->integer('hoursBefore')->nullable();
			$table->enum('expiration', array('none', 'hours', 'weeks', 'days', 'months', 'years'))->default('none');
			$table->integer('expiration_value')->nullable();
			$table->foreign('id_process')->references('id')->on('processes')->onDelete('cascade');
			$table->foreign('id_activity')->references('id')->on('activities')->onDelete('cascade');
			$table->foreign('id_typesStart')->references('id')->on('typesStarts')->onDelete('restrict');
			$table->foreign('id_typesEnd')->references('id')->on('typesEnds')->onDelete('restrict');
			$table->foreign('id_typesAssignment')->references('id')->on('typesAssignments')->onDelete('restrict');
			$table->foreign('id_typesNotification')->references('id')->on('typesNotifications')->onDelete('restrict');
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
		Schema::drop('activitiesProcesses');
	}

}
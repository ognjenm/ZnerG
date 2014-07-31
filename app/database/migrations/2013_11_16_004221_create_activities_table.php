<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->unsignedInteger('id_application')->nullable();
			$table->unsignedInteger('id_subprocess')->nullable();
			$table->unsignedInteger('id_typesActivity');
			$table->string('name',64);
			$table->string('description',256)->nullable();
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->enum('isSystem', array('No', 'Yes'))->default('No');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('restrict');
			$table->foreign('id_application')->references('id')->on('applications')->onDelete('cascade');
			$table->foreign('id_subprocess')->references('id')->on('processes')->onDelete('cascade');
			$table->foreign('id_typesActivity')->references('id')->on('typesActivities')->onDelete('restrict');
		});

		Schema::table('processes', function(Blueprint $table) {
			$table->foreign('id_initialActivity')->references('id')->on('activities')->onDelete('set null');
			$table->foreign('id_finalActivity')->references('id')->on('activities')->onDelete('set null');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activities');
	}

}
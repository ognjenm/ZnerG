<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldsApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fieldsApplications', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_application');
			$table->unsignedInteger('id_field');
			$table->string('label',64);
			$table->string('description',256)->nullable();
			$table->enum('isVisible', array('Yes', 'No'))->default('No');
			$table->enum('isEditable', array('Yes', 'No'))->default('Yes');
			$table->enum('isCreatable', array('Yes', 'No'))->default('Yes');
			$table->enum('isDeletable', array('Yes', 'No'))->default('Yes');
			$table->smallInteger('position');
			$table->smallInteger('size')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_application')->references('id')->on('applications')->onDelete('restrict');
			$table->foreign('id_field')->references('id')->on('fields')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fieldsApplications');
	}

}
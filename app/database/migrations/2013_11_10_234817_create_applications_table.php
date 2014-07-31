<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applications', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_metaData')->nullable();
			$table->unsignedInteger('id_typesApplication');
			$table->string('name',64);
			$table->string('description',256)->nullable();
			$table->string('externalReference',256)->nullable();
			$table->enum('isActive', array('Yes', 'No'))->default('No');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_metaData')->references('id')->on('metaDatas')->onDelete('set null');
			$table->foreign('id_typesApplication')->references('id')->on('typesApplications')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('applications');
	}

}
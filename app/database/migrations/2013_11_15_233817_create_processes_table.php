<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('processes', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->unsignedInteger('id_campaign')->nullable();
			$table->unsignedInteger('id_initialActivity')->nullable();
			$table->unsignedInteger('id_finalActivity')->nullable();
			$table->unsignedInteger('id_metaData')->nullable();
			$table->unsignedInteger('id_typesProcess');
			$table->string('name',64);
			$table->string('description',256)->nullable();
			$table->enum('audit', array('Yes', 'No'))->default('Yes');
			$table->enum('log', array('Yes', 'No'))->default('No');
			$table->enum('isActive', array('Yes', 'No'))->default('No');
			$table->date('startDate')->nullable();
			$table->date('endDate')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('cascade');
			$table->foreign('id_campaign')->references('id')->on('campaigns')->onDelete('set null');
			$table->foreign('id_metaData')->references('id')->on('metaDatas')->onDelete('set null');
			$table->foreign('id_typesProcess')->references('id')->on('typesProcesses')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('processes');
	}

}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationParametersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizationParameters', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_parameter');
			$table->unsignedInteger('id_organization');
			$table->primary(array('id_parameter', 'id_organization'));
			$table->string('value',64)->nullable();
			$table->timestamps();
			$table->foreign('id_parameter')->references('id')->on('parameters')->onDelete('cascade');
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organizationParameters');
	}

}
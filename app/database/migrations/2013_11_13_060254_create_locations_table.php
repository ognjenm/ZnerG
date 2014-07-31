<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_business');
			$table->unsignedInteger('id_address');
			$table->unsignedInteger('id_statusLocation');
			$table->string('phone',10)->nullable();
			$table->string('phoneAdditional',10)->nullable();
			$table->string('fax',10)->nullable();
			$table->enum('isActive', array('Yes','No'))->default('Yes');
			$table->enum('isHeadquarter', array('Yes','No'))->default('Yes');
			$table->enum('isBilling', array('Yes','No'))->default('No');
			$table->enum('isShipping', array('Yes','No'))->default('No');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_business')->references('id')->on('businesses')->onDelete('restrict');
			$table->foreign('id_address')->references('id')->on('addresses')->onDelete('cascade');
			$table->foreign('id_statusLocation')->references('id')->on('statusLocations')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('locations');
	}

}
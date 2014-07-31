<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->unsignedInteger('id_address')->nullable();
			$table->string('name',32);
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('restrict');
			$table->foreign('id_address')->references('id')->on('addresses')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}
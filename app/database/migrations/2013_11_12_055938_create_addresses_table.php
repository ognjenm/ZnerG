<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_city');
			$table->unsignedInteger('id_database');
			$table->unsignedInteger('id_statusAddress');
			$table->unsignedInteger('id_typesAddress');
			$table->string('addressLine1',256);
			$table->string('addressLine2',256)->nullable();
			$table->string('suite',8)->nullable();
			$table->string('zipcode',10)->nullable();
			$table->decimal('latitude',10,8)->nullable();
			$table->decimal('longitude',10,8)->nullable();
			$table->string('reference',256)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_city')->references('id')->on('cities')->onDelete('restrict');
			$table->foreign('id_database')->references('id')->on('databases')->onDelete('restrict');
			$table->foreign('id_statusAddress')->references('id')->on('statusAddresses')->onDelete('restrict');
			$table->foreign('id_typesAddress')->references('id')->on('typesAddresses')->onDelete('restrict');
			$table->index('latitude');
			$table->index('longitude');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('addresses');
	}

}
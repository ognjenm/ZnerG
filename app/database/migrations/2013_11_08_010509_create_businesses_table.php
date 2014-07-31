<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('businesses', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_database');
			$table->string('name',64);
			$table->integer('numberEmployees')->nullable();
			$table->date('foundation')->nullable();
			$table->string('email',64)->nullable();
			$table->string('website',64)->nullable();
			$table->string('description',128)->nullable();
			$table->string('note',256)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_database')->references('id')->on('databases')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('businesses');
	}

}
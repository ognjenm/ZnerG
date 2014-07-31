<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldsMappingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fieldsMappings', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_rule');
			$table->unsignedInteger('id_field');
			$table->string('value',256);
			$table->timestamps();
			$table->foreign('id_rule')->references('id')->on('rules')->onDelete('restrict');
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
		Schema::drop('fieldsMappings');
	}

}
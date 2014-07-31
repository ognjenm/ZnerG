<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParametersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parameters', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_category');
			$table->string('name',32)->unique();
			$table->string('description',256)->nullable();
			$table->string('value',64)->nullable();
			$table->enum('access', array('System', 'Organization', 'User'))->default('System');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_category')->references('id')->on('categoriesParameters')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('parameters');
	}

}

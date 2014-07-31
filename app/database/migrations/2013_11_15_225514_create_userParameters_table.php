<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserParametersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userParameters', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_parameter');
			$table->unsignedInteger('id_user');
			$table->primary(array('id_parameter', 'id_user'));
			$table->foreign('id_parameter')->references('id')->on('parameters')->onDelete('cascade');
			$table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
			$table->string('value',64)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('userParameters');
	}

}
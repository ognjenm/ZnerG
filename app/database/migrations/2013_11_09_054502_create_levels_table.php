<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('levels', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->string('name',32);
			$table->string('description', 256)->nullable();
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->integer('value');
			$table->timestamps();
			$table->softDeletes();
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
		Schema::drop('levels');
	}

}
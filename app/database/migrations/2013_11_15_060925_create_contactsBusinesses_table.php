<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsBusinessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contactsBusinesses', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_business');
			$table->unsignedInteger('id_contact');
			$table->string('position',32)->nullable();
			$table->enum('dayMonday', array('Yes', 'No'))->default('Yes');
			$table->enum('dayTuesday', array('Yes', 'No'))->default('Yes');
			$table->enum('dayWednesday', array('Yes', 'No'))->default('Yes');
			$table->enum('dayThursday', array('Yes', 'No'))->default('Yes');
			$table->enum('dayFriday', array('Yes', 'No'))->default('Yes');
			$table->enum('daySaturday', array('No', 'Yes'))->default('No');
			$table->enum('daySunday', array('No', 'Yes'))->default('No');
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->time('start')->default('09:00');
			$table->time('end')->default('17:00');
			$table->string('scheduleNotes',256)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_business')->references('id')->on('businesses')->onDelete('restrict');
			$table->foreign('id_contact')->references('id')->on('contacts')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contactsBusinesses');
	}

}
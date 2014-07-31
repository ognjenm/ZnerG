<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_database')->nullable();
			$table->unsignedInteger('id_address')->nullable();
			$table->string('firstName',16);
			$table->string('lastName',32)->nullable();
			$table->date('dateOfBirth')->nullable();
			$table->string('driverLicense')->nullable();
			$table->string('phone',11)->nullable();
			$table->string('phoneAdditional',11)->nullable();
			$table->string('email',64)->nullable();
			$table->string('emailAdditional',64)->nullable();
			$table->text('notes')->nullable();
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_database')->references('id')->on('databases')->onDelete('restrict');
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
		Schema::drop('contacts');
	}

}
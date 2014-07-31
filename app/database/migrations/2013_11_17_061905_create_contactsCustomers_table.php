<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contactsCustomers', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_customer');
			$table->unsignedInteger('id_contact');
			$table->enum('isDecisionMaker', array('Yes', 'No'))->default('Yes');
			$table->primary(array('id_customer', 'id_contact'));
			$table->foreign('id_customer')->references('id')->on('customers')->onDelete('cascade');
			$table->foreign('id_contact')->references('id')->on('contacts')->onDelete('cascade');
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
		Schema::drop('contactsCustomers');
	}

}
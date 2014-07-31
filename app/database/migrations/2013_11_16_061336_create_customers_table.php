<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_location');
			$table->unsignedInteger('id_campaign');
			$table->unsignedInteger('id_statusCustomer');
			$table->unsignedInteger('id_typesCustomer');
			$table->unsignedInteger('id_typesBusiness')->nullable();
			$table->unsignedInteger('id_referral')->nullable();
			$table->string('account',16);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_location')->references('id')->on('locations')->onDelete('restrict');
			$table->foreign('id_campaign')->references('id')->on('campaigns')->onDelete('restrict');
			$table->foreign('id_statusCustomer')->references('id')->on('statusCustomers')->onDelete('restrict');
			$table->foreign('id_typesCustomer')->references('id')->on('typesCustomers')->onDelete('restrict');
			$table->foreign('id_typesBusiness')->references('id')->on('typesBusinesses')->onDelete('restrict');
			$table->foreign('id_referral')->references('id')->on('referrals')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
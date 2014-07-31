<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesCampaignsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employeesCampaigns', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_employee');
			$table->unsignedInteger('id_campaign');
			$table->primary(array('id_employee', 'id_campaign'));
			$table->foreign('id_employee')->references('id')->on('employees')->onDelete('cascade');
			$table->foreign('id_campaign')->references('id')->on('campaigns')->onDelete('cascade');
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
		Schema::drop('employeesCampaigns');
	}

}
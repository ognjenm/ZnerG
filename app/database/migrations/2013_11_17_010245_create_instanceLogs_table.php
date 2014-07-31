<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstanceLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('instanceLogs', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_instance');
			$table->string('employee',64);
			$table->string('process',64);
			$table->string('activity',64);
			$table->string('event',64);
			$table->datetime('datetime');
			$table->timestamps();
			$table->foreign('id_instance')->references('id')->on('instances')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('instanceLogs');
	}

}
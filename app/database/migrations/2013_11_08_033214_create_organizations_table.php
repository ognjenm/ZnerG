<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_parent')->nullable();
			$table->unsignedInteger('id_database')->nullable();
			$table->string('shortName',16)->unique();
			$table->string('name',64);
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->enum('isSystem', array('Yes', 'No'))->default('No');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_database')->references('id')->on('databases')->onDelete('set null');
		});
		
		Schema::table('organizations', function(Blueprint $table) {
			$table->foreign('id_parent')->references('id')->on('organizations')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organizations');
	}

}

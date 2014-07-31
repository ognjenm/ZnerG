<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usersGroups', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_user');
			$table->unsignedInteger('id_group');
			$table->primary(array('id_user', 'id_group'));
			$table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('id_group')->references('id')->on('groups')->onDelete('cascade');
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
		Schema::drop('usersGroups');
	}

}
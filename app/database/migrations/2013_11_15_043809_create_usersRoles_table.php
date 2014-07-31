<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usersRoles', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_user');
			$table->unsignedInteger('id_role');
			$table->date('startDate')->nullable();
			$table->date('endDate')->nullable();
			$table->primary(array('id_user', 'id_role'));
			$table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
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
		Schema::drop('usersRoles');
	}

}
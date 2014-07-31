<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rolesGroups', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_role');
			$table->unsignedInteger('id_group');
			$table->primary(array('id_role', 'id_group'));
			$table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
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
		Schema::drop('rolesGroups');
	}

}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rolesOptions', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedInteger('id_role');
			$table->unsignedInteger('id_option');
			$table->boolean('insert')->nullable()->default(0);
			$table->boolean('update')->nullable()->default(0);
			$table->boolean('delete')->nullable()->default(0);
			$table->boolean('execute')->nullable()->default(0);
			$table->primary(array('id_option', 'id_role'));
			$table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
			$table->foreign('id_option')->references('id')->on('options')->onDelete('cascade');
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
		Schema::drop('rolesOptions');
	}

}
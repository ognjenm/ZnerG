<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_organization');
			$table->unsignedInteger('id_employee')->nullable();
			$table->unsignedInteger('id_recoveryQuestion')->nullable();
			$table->string('username', 64);
			$table->string('password', 64);
			$table->string('email', 64);
			$table->string('alternativeId', 10)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->enum('isSystem', array('Yes', 'No'))->default('No');
			$table->string('answer', 50);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_organization')->references('id')->on('organizations')->onDelete('restrict');
			$table->foreign('id_employee')->references('id')->on('employees')->onDelete('set null');
			$table->foreign('id_recoveryQuestion')->references('id')->on('recoveryQuestions')->onDelete('set null');
			$table->index(array('id_organization', 'username'));
			$table->index(array('id_organization', 'email'));
			$table->index(array('id_organization', 'alternativeId'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

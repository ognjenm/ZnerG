<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNonqualifiedReasonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nonqualifiedReasons', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_campaign');
			$table->string('name',128);
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_campaign')->references('id')->on('campaigns')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nonqualifiedReasons');
	}

}

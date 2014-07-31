<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ordersDetails', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->unsignedInteger('id_order');
			$table->unsignedInteger('id_unitsMeasure');
			$table->unsignedInteger('id_color');
			$table->string('effort',6);
			$table->string('itemNumber',12);
			$table->smallInteger('quantity');
			$table->string('description',128);
			$table->decimal('unitPrice',10,2);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_order')->references('id')->on('orders')->onDelete('restrict');
			$table->foreign('id_unitsMeasure')->references('id')->on('unitsMeasures')->onDelete('restrict');
			$table->foreign('id_color')->references('id')->on('colors')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ordersDetails');
	}

}
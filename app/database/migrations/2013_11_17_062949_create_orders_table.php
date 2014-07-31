<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_employee');
			$table->unsignedInteger('id_customer');
			$table->unsignedInteger('id_currency');
			$table->unsignedInteger('id_statusOrder');
			$table->unsignedInteger('id_typesOrder');
			$table->integer('number');
			$table->datetime('datetime');
			$table->decimal('totalBeforeTax',10,2);
			$table->decimal('tax',10,2);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_employee')->references('id')->on('employees')->onDelete('restrict');
			$table->foreign('id_customer')->references('id')->on('customers')->onDelete('restrict');
			$table->foreign('id_currency')->references('id')->on('currencies')->onDelete('restrict');
			$table->foreign('id_statusOrder')->references('id')->on('statusOrders')->onDelete('restrict');
			$table->foreign('id_typesOrder')->references('id')->on('typesOrders')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
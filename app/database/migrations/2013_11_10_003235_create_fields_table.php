<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('id_metaData');
			$table->string('name',64);
			$table->string('description',256)->nullable();
			$table->enum('isLinked', array('Yes', 'No'))->default('No');
			$table->unsignedInteger('id_dataType')->nullable();
			$table->integer('length')->nullable();
			$table->integer('precision')->nullable();
			$table->integer('scale')->nullable();
			$table->string('values',256)->nullable();
			$table->string('default',256)->nullable();
			$table->enum('isNullable', array('Yes', 'No'))->default('No');
			$table->unsignedInteger('id_structure')->nullable();
			$table->string('relations',256)->nullable();
			$table->enum('hasAssistant', array('No', 'Yes'))->default('No');
			$table->enum('isFullSearch', array('No', 'Yes'))->default('No');
			$table->enum('isReference', array('No', 'Yes'))->default('No');
			$table->tinyInteger('positionReference')->nullable();
			$table->tinyInteger('positionUI')->nullable();
			$table->enum('isEditable', array('Yes', 'No'))->default('Yes');
			$table->enum('isCreatable', array('Yes', 'No'))->default('Yes');
			$table->enum('isDeletable', array('Yes', 'No'))->default('Yes');
			$table->enum('isVisible', array('Yes', 'No'))->default('Yes');
			$table->enum('isDisabled', array('No', 'Yes'))->default('No');
			$table->enum('isActive', array('Yes', 'No'))->default('Yes');
			$table->enum('isSystem', array('No', 'Yes'))->default('No');
			$table->enum('isPk', array('No', 'Yes'))->default('No');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('id_metaData')->references('id')->on('metaDatas')->onDelete('restrict');
			$table->foreign('id_dataType')->references('id')->on('dataTypes')->onDelete('restrict');
			$table->foreign('id_structure')->references('id')->on('structures')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fields');
	}

}
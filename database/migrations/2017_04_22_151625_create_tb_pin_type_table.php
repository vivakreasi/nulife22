<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPinTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_pin_type')) {
			Schema::create('tb_pin_type', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('pin_type_name', 100);
				$table->integer('business_rights_amount');
				$table->integer('pin_type_price');
				$table->integer('pin_type_stockis_price');
				$table->integer('pin_type_masterstockis_price');
				$table->timestamps();
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tb_pin_type');
	}

}

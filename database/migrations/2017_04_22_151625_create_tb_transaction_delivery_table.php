<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTransactionDeliveryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_transaction_delivery')) {
			Schema::create('tb_transaction_delivery', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->integer('transaction_id');
				$table->tinyInteger('delivery_sequence');
				$table->integer('delivery_province_id')->nullable();
				$table->integer('delivery_city_id')->nullable();
				$table->string('delivery_zip_code')->nullable();
				$table->string('delivery_address')->nullable();
				$table->string('delivery_attn')->nullable();
				$table->string('delivery_attn_phone')->nullable();
				$table->tinyInteger('delivery_status')->nullable();
				$table->integer('delivery_carrier')->nullable();
				$table->string('delivery_carrier_awb')->nullable();
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
		Schema::dropIfExists('tb_transaction_delivery');
	}

}

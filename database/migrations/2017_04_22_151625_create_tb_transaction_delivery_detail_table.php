<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTransactionDeliveryDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_transaction_delivery_detail')) {
			Schema::create('tb_transaction_delivery_detail', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->integer('id')->primary();
				$table->integer('transaction_delivery_id');
				$table->integer('product_id');
				$table->integer('amount');
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
		Schema::dropIfExists('tb_transaction_delivery_detail');
	}

}

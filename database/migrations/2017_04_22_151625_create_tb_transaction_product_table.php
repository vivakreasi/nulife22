<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTransactionProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_transaction_product')) {
			Schema::create('tb_transaction_product', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->integer('transaction_id');
				$table->integer('product_id');
				$table->integer('amount')->nullable();
				$table->integer('total_price')->nullable();
				$table->integer('total_delivery_cost')->nullable();
				$table->integer('unique_digit')->nullable();
				$table->tinyInteger('payment_status')->nullable();
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
		Schema::dropIfExists('tb_transaction_product');
	}

}

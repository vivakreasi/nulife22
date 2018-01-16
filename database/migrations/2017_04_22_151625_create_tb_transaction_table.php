<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_transaction')) {
			Schema::create('tb_transaction', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('transaction_code', 32);
				$table->tinyInteger('transaction_type')->default(1);
				$table->integer('from')->nullable();
				$table->integer('to')->nullable();
				$table->integer('total_price')->nullable();
				$table->integer('unique_digit')->nullable()->default('000');
				$table->tinyInteger('status')->nullable();
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
		Schema::dropIfExists('tb_transaction');
	}

}

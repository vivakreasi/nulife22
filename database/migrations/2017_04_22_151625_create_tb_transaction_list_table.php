<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbTransactionListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_transaction_list')) {
			Schema::create('tb_transaction_list', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('transaction_code', 32);
				$table->integer('pin_type_id');
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
		Schema::dropIfExists('tb_transaction_list');
	}

}

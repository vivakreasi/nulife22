<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPinMemberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_pin_member')) {
			Schema::create('tb_pin_member', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('pin_code', 32);
				$table->integer('pin_type_id');
				$table->integer('user_id');
				$table->string('transaction_code', 32);
				$table->tinyInteger('is_used')->default(0);
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
		Schema::dropIfExists('tb_pin_member');
	}

}

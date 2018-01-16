<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPinTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_pin')) {
			Schema::create('tb_pin', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('pin_code', 32);
				$table->integer('pin_type_id');
				$table->tinyInteger('is_sold')->default(0);
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
		Schema::dropIfExists('tb_pin');
	}

}

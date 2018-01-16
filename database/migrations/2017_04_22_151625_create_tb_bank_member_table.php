<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbBankMemberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_bank_member')) {
			Schema::create('tb_bank_member', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->integer('user_id');
				$table->string('bank_name', 50);
				$table->string('account_no', 50);
				$table->string('account_name', 50);
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
		Schema::dropIfExists('tb_bank_member');
	}

}

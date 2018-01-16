<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('tb_product')) {
			Schema::create('tb_product', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->integer('id')->primary();
				$table->string('product_name', 100)->nullable();
				$table->string('product_code', 32)->nullable();
				$table->string('product_barcode', 100)->nullable();
				$table->integer('product_price')->nullable();
				$table->integer('product_weight')->nullable();
				$table->text('product_desc', 65535)->nullable();
				$table->string('product_image_1', 100)->nullable();
				$table->string('product_image_2', 100)->nullable();
				$table->string('product_image_3', 100)->nullable();
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
		Schema::dropIfExists('tb_product');
	}

}

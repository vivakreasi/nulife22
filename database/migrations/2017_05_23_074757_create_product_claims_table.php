<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_claims', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('userid',20);
            $table->string('type',1);
            $table->text('code');
            $table->integer('sequence')->unsigned()->default(1);
            $table->integer('inv_trans_id')->unsigned()->nullable();
            $table->integer('status'); //1=new ; 2=onprocess (full) ; 3=on process (partial) ; 4=received
            $table->decimal('quantity', 8, 2)->default(0);
            $table->decimal('delivered_quantity', 8, 2)->default(0);
            $table->string('delivery_awb',50);
            $table->string('delivery_name',50);
            $table->string('delivery_address',255);
            $table->integer('delivery_city')->unsigned();
            $table->integer('delivery_province')->unsigned();
            $table->string('delivery_zip_code',5);
            $table->string('delivery_phone',20);
            $table->timestamps();

            $table->index('user_id');
            $table->index('inv_trans_id');
            $table->index('sequence');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_product_claims');
    }
}

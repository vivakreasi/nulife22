<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbRequestStockist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_request_stockist')) {
            Schema::create('tb_request_stockist', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('request_code', 15)->unique();
                $table->integer('user_id');
                $table->string('userid', 20);
                $table->smallInteger('type_stockist_id');
                $table->integer('bank_company_id');
                $table->integer('jml_pin');
                $table->integer('harga_pin');
                $table->bigInteger('total_harga');
                $table->smallInteger('angka_unik');
                $table->bigInteger('total_transfer');
                $table->tinyInteger('status')->default(0);
                $table->string('bukti_transfer', 35)->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('transfer_at')->nullable();
                $table->timestamp('confirm_at')->nullable();
                $table->timestamp('reject_at')->nullable();
                
                $table->index('user_id');
                $table->index('status');
                $table->index('bank_company_id');
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
        Schema::dropIfExists('tb_request_stockist');
    }
}

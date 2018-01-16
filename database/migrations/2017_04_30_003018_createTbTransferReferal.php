<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTransferReferal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if (!Schema::hasTable('tb_transfer_referal')) {
            Schema::create('tb_transfer_referal', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('from');
                $table->integer('to');
                $table->integer('price');
                $table->string('bank', 50);
                $table->string('bank_account', 15);
                $table->string('account_name', 60);
                $table->string('file_upload', 50);
                $table->smallInteger('hak_usaha');
                $table->tinyInteger('is_approve')->default(0);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('transfer_at')->nullable();
                $table->timestamp('approve_at')->nullable();
                
                $table->index('from');
                $table->index('to');
                $table->index('is_approve');
            });
        }
    }

    public function down(){
        Schema::dropIfExists('tb_transfer_referal');
    }
}

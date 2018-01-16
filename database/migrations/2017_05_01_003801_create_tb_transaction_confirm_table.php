<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTransactionConfirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_transaction_confirm')) {
            Schema::create('tb_transaction_confirm', function(Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('transaction_code', 32);
                $table->string('filename', 100);
                $table->string('bank_name', 50);
                $table->string('account_no', 50);
                $table->string('account_name', 50);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('tb_transaction_confirm');
    }
}

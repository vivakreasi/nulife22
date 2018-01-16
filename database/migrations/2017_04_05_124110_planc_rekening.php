<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlancRekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_c_bank')) {
            Schema::create('tb_plan_c_bank', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('bank_name');
                $table->string('bank_account');
                $table->string('bank_account_name');
                $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('tb_plan_c_bank');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_nulife_bank_plan_c')) {
            Schema::create('tb_nulife_bank_plan_c', function (Blueprint $table) {
                $table->increments('id');
                $table->string('bank_name');
                $table->string('bank_account');
                $table->string('bank_account_name');
                $table->string('ib_username');
                $table->string('ib_password');
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
        Schema::dropIfExists('tb_nulife_bank_plan_c');
    }
}

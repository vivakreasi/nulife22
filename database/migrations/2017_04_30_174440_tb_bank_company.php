<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbBankCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_bank_company')) {
            Schema::create('tb_bank_company', function (Blueprint $table) {
                $table->increments('id');
                $table->string('bank_code', 4);
                $table->string('bank_name', 50);
                $table->string('bank_account', 30);
                $table->string('bank_account_name', 100);
                $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('tb_bank_company');
    }
}

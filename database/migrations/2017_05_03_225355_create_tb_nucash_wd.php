<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbNucashWd extends Migration{

    public function up(){
        if (!Schema::hasTable('tb_nucash_wd')) {
            Schema::create('tb_nucash_wd', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('id_user');
                $table->bigInteger('jml_wd');
                $table->timestamp('tgl_wd')->useCurrent();
                $table->string('kd_wd', 25);
                $table->integer('adm_fee');
                $table->bigInteger('total_wd');
                $table->tinyInteger('is_transfer')->default(0);
                $table->timestamp('transfer_at')->nullable();
                $table->integer('user_bank');
                $table->tinyInteger('is_confirm')->default(0);
                $table->timestamp('confirm_at')->nullable();
                
                $table->index('id_user');
                $table->index('kd_wd');
                $table->index('is_transfer');
                $table->index('is_confirm');
            });
        }
    }

    public function down(){
        Schema::dropIfExists('tb_nucash_wd');
    }
}

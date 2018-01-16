<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatikSetting extends Migration{
    public function up(){
        if (!Schema::hasTable('tb_statik_settings')) {
            Schema::create('tb_statik_settings', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('max_bank');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            });
        }
    }
    
    public function down(){
        Schema::dropIfExists('tb_statik_settings');
    }
}

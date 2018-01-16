<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryUserType extends Migration{

    public function up(){
        if (!Schema::hasTable('history_user_type')) {
            Schema::create('history_user_type', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('id_user');
                $table->integer('id_user_type');
                $table->timestamp('user_type_at')->useCurrent();
                
                $table->index('id_user');
                $table->index('id_user_type');
            });
        }
    }

    public function down(){
        Schema::dropIfExists('history_user_type');
    }
}

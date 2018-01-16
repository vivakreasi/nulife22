<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersType extends Migration{

    public function up(){
        if (!Schema::hasTable('users_type')) {
            Schema::create('users_type', function (Blueprint $table) {
                $table->integer('id')->primary();
                $table->string('code', 20)->unique();
                $table->string('desc', 50);
                $table->string('short_desc', 30)->nullable();
                $table->integer('left_target')->default(0);
                $table->integer('right_target')->default(0);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            });
        }
    }

    public function down(){
        Schema::dropIfExists('users_type');
    }
}

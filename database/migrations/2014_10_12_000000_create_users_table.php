<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration{

    public function up(){
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name', 100);
                $table->string('email', 100);
                $table->string('hp', 50);
                $table->string('userid', 60)->unique();
                $table->string('password', 64);
                $table->integer('id_type')->default(0);
                $table->tinyInteger('is_active_type')->default(0);
                $table->timestamp('active_type_at')->nullable();
                $table->tinyInteger('is_stockis')->default(0);
                $table->integer('id_referal')->default(0);
                $table->tinyInteger('is_active')->default(0);
                $table->timestamp('active_at')->nullable();
                $table->smallInteger('plan_status')->default(0);
                $table->timestamp('plan_status_at')->nullable();
                $table->string('id_join_type', 13)->nullable();
                $table->tinyInteger('is_referal_link')->default(0);
                $table->rememberToken();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->index('hp');
                $table->index('id_type');
                $table->index('id_referal');
            });
        }
    }

    public function down(){
        Schema::dropIfExists('users');
    }
    
}
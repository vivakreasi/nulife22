<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersProfile extends Migration{

    public function up(){
        if (!Schema::hasTable('users_profile')) {
            Schema::create('users_profile', function (Blueprint $table) {
                $table->integer('id_user');
                $table->string('avatar', 100)->nullable();
                $table->text('alamat')->nullable();
                $table->integer('provinsi')->nullable();
                $table->integer('kota')->nullable();
                $table->string('kode_pos', 6)->nullable();
                $table->string('gender', 1)->nullable();
                $table->string('ktp', 20)->nullable();
                $table->string('ktp_file', 50)->nullable();
                $table->string('paspor', 20)->nullable();
                $table->string('paspor_file', 50)->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->primary('id_user');
            });
        }
    }

    public function down(){
        Schema::dropIfExists('users_profile');
    }
    
}

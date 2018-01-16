<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewContent extends Migration{
    public function up(){
        if (!Schema::hasTable('tb_view_contents')) {
            Schema::create('tb_view_contents', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('user_id');
                $table->integer('content_id');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->index('user_id');
                $table->index('content_id');
            });
        }
    }
    
    public function down(){
        Schema::dropIfExists('tb_view_contents');
    }
}

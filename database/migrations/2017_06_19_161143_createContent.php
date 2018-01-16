<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContent extends Migration{
    public function up(){
        if (!Schema::hasTable('tb_contents')) {
            Schema::create('tb_contents', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('created_by');
                $table->string('title', 100);
                $table->text('sort_desc');
                $table->text('desc');
                $table->string('image_url', 255);
                $table->tinyInteger('publish')->default(1);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->index('title');
                $table->index('image_url');
                $table->index('publish');
            });
        }
    }
    
    public function down(){
        Schema::dropIfExists('tb_contents');
    }
}

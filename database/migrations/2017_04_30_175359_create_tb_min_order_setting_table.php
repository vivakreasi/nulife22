<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbMinOrderSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_min_order_setting')) {
            Schema::create('tb_min_order_setting', function(Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name', 50);
                $table->integer('amount');
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
        Schema::dropIfExists('tb_min_order_setting');
    }
}

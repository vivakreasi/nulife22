<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbBonusPairing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_bonus_pairing')) {
            Schema::create('tb_bonus_pairing', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('userid', 20);
                $table->integer('left_id');
                $table->integer('left_user_id');
                $table->string('left_userid', 20);
                $table->integer('right_id');
                $table->integer('right_user_id');
                $table->string('right_userid', 20);
                $table->integer('pair_level');
                $table->integer('bonus_amount');
                $table->integer('nucash_amount');
                $table->integer('nupoint_amount');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->unique(['user_id', 'left_id']);
                $table->unique(['user_id', 'left_user_id']);
                $table->unique(['user_id', 'right_id']);
                $table->unique(['user_id', 'right_user_id']);
                $table->index('left_id');
                $table->index('left_user_id');
                $table->index('left_userid');
                $table->index('right_id');
                $table->index('right_user_id');
                $table->index('right_userid');
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
        Schema::dropIfExists('tb_bonus_pairing');
    }
}

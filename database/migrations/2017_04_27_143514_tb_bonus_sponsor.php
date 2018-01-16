<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbBonusSponsor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_bonus_sponsor')) {
            Schema::create('tb_bonus_sponsor', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('userid', 20);
                $table->integer('from_user_id');
                $table->string('from_userid', 20);
                $table->integer('bonus_amount');
                $table->integer('nucash_amount');
                $table->integer('nupoint_amount');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->unique(['user_id', 'from_user_id']);
                $table->index('userid');
                $table->index('from_user_id');
                $table->index('from_userid');
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
        Schema::dropIfExists('tb_bonus_sponsor');
    }
}

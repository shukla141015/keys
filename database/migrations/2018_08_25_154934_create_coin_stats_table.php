<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinStatsTable extends Migration
{
    public function up()
    {
        Schema::create('coin_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('coin');
            $table->unsignedInteger('random_pages_generated')->default(0);
            $table->unsignedInteger('pages_viewed')->default(0);
            $table->unsignedInteger('keys_generated')->default(0);
            $table->unsignedInteger('times_searched')->default(0);

            $table->unique(['date', 'coin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('coin_stats');
    }
}

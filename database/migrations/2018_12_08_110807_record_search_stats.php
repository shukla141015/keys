<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordSearchStats extends Migration
{
    public function up()
    {
        Schema::table('coin_stats', function (Blueprint $table) {
            $table->unsignedInteger('times_searched')->default(0);
        });
    }

    public function down()
    {
        //
    }
}

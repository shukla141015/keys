<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiggestRandomPagesTable extends Migration
{
    public function up()
    {
        Schema::create('biggest_random_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coin');
            $table->string('page_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biggest_random_pages');
    }
}

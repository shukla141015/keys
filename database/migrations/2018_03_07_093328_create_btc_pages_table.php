<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBtcPagesTable extends Migration
{
    public function up()
    {
        Schema::create('btc_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_number')->index();
            $table->boolean('empty');
            $table->timestamps();

            $table->unique('page_number');
        });
    }

    public function down()
    {
        Schema::dropIfExists('btc_pages');
    }
}

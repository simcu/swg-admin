<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpstreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upstreams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['weight', 'ip_hash']);
            $table->enum('schema', ['http', 'https']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upstreams');
    }
}

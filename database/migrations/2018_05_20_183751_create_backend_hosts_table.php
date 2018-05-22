<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackendHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_hosts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('backend_id');
            $table->string('ip');
            $table->integer('port');
            $table->boolean('check');
            $table->integer('inter')->default(2000);
            $table->integer('rise')->default(3);
            $table->integer('fall')->default(3);
            $table->integer('weight')->default(30);
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
        Schema::dropIfExists('backend_hosts');
    }
}

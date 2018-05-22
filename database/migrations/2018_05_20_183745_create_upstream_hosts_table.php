<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpstreamHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upstream_hosts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('upstream_id');
            $table->string('ip');
            $table->integer('port');
            $table->integer('weight')->default(10);
            $table->integer('max_fails')->default(10);
            $table->integer('fail_timeout')->default(120);
            $table->boolean('backup');
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
        Schema::dropIfExists('upstream_hosts');
    }
}

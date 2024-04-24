<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayoutChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playout_channels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('instance_id')->nullable();
            $table->index('instance_id');
            $table->uuid('channel_id')->nullable();
            $table->index('channel_id');
            $table->uuid('tenant_id')->nullable();
            $table->index('tenant_id');
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
        Schema::dropIfExists('playout_channels');
    }
}

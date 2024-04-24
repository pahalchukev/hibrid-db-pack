<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelayedStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delayed_streams', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('stream_id');
            $table->foreign('stream_id')
                ->references('id')
                ->on('live_streams')
                ->cascadeOnDelete();


            $table->uuid('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->uuid('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('recording_type');
            $table->index('recording_type');

            $table->text('selected_days')->nullable();

            $table->string('start_at');
            $table->string('stop_at');

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
        Schema::dropIfExists('delayed_streams');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelayedStreamsSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delayed_stream_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('stream_id');
            $table->foreign('stream_id')
                ->references('id')
                ->on('live_streams')
                ->cascadeOnDelete();

            $table->uuid('delayed_stream_id');
            $table->foreign('delayed_stream_id')
                ->references('id')
                ->on('delayed_streams')
                ->cascadeOnDelete();

            $table->string('command');

            $table->timestamp('execute_at');
            $table->index('execute_at');

            $table->timestamp('executed_at')->nullable();

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delayed_stream_schedules');
    }
}

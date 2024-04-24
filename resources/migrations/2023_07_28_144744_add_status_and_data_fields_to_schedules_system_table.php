<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndDataFieldsToSchedulesSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('status')->nullable()->after('intro_id');
            $table->json('message')->nullable()->after('status');
            $table->json('hls_history')->nullable()->after('message');
            $table->json('extra')->nullable()->after('hls_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['status', 'message', 'hls_history', 'extra']);
        });
    }
}

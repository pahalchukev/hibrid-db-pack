<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntroAndOutroFieldsToSchedulesSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->uuid('intro_id')->nullable()->after('ad_breaks');
            $table->uuid('outro_id')->nullable()->after('ad_breaks');
            $table->integer('intro_duration')->default(0);
            $table->integer('outro_duration')->default(0);

            $table->foreign('intro_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

            $table->foreign('outro_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

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
            $table->dropColumn(['intro_id', 'outro_id', 'intro_duration', 'outro_duration']);
        });
    }
}

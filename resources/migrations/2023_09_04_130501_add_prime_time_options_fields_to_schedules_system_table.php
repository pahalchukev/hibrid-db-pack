<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrimeTimeOptionsFieldsToSchedulesSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['prime_time_options']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->string('prime_time_fill')->nullable()->after('prime_time');
            $table->string('prime_time_overlap')->nullable()->after('prime_time_fill');
            $table->uuid('prime_time_filler')->nullable()->after('prime_time_overlap');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['prime_time_fill', 'prime_time_overlap', 'prime_time_filler']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->json('prime_time_options')->nullable()->after('prime_time');
        });
    }
}

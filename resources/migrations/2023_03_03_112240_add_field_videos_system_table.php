<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldVideosSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('videos', function (Blueprint $table) {
            $table->json('posters')->nullable()->after('thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('videos', function (Blueprint $table) {
            $table->dropColumn(['posters']);
        });
    }
}

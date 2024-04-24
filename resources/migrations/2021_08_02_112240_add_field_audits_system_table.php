<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldAuditsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('audits', function (Blueprint $table) {
            $table->string('title')->nullable()->after('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('audits', function (Blueprint $table) {
            $table->dropColumn(['title']);
        });
    }
}

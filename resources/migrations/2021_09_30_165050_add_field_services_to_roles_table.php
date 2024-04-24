<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldServicesToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('roles', function (Blueprint $table) {
            $table->text('services')->nullable()->after('guard_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('roles', function (Blueprint $table) {
            $table->dropColumn(['services']);
        });
    }
}

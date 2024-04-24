<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldServiceToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('permissions', function (Blueprint $table) {
            $table->string('service')->nullable()->after('guard_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('permissions', function (Blueprint $table) {
            $table->dropColumn(['service']);
        });
    }
}

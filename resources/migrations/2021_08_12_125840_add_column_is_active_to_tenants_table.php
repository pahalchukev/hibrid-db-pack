<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnIsActiveToTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('tenants', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('contact_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('tenants', function (Blueprint $table) {
            $table->dropColumn(['is_active']);
        });
    }
}

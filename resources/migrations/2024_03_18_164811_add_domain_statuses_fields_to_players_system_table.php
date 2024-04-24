<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDomainStatusesFieldsToPlayersSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('domain_status')->default('everywhere-except-were-blocked')->after('tenant_id');
            $table->json('blocked_links')->nullable()->after('domain_status');
            $table->json('allowed_links')->nullable()->after('blocked_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn(['domain_status', 'blocked_links', 'allowed_links']);
        });
    }
}

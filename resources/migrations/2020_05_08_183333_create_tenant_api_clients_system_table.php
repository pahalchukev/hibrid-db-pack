<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantApiClientsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('tenant_api_clients', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('client_id');
            $table->string('access_token', 255);
            $table->uuid('created_by')->nullable();
            $table->uuid('tenant_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
                ->on('users')
                ->references('id')
                ->onDelete('set null');

            $table->foreign('tenant_id')
                ->on('tenants')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->dropIfExists('tenant_api_clients');
    }
}

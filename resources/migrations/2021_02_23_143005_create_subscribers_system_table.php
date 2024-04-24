<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscribersSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('subscribers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('balance')->default(0);
            $table->json('meta_data')->nullable();
            $table->boolean('status')->default(false);

            $table->uuid('tenant_id');
            $table->uuid('api_client_id')->nullable();
            $table->timestamps();


            $table->foreign('api_client_id')
                ->on('tenant_api_clients')
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
        $this->dropIfExists('subscribers');
    }
}

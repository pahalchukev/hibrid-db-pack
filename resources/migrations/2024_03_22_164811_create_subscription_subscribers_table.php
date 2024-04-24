<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('subscription_subscribers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('subscription_id');
            $table->string('subscriber_id');
            $table->uuid('tenant_id');
            $table->uuid('api_client_id');
            $table->decimal('price')->default(0);
            $table->string('type');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions')
                ->onDelete('cascade');

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');

            $table->foreign('api_client_id')
                ->references('id')
                ->on('tenant_api_clients')
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
        Schema::dropIfExists('subscription_subscribers');
    }
}

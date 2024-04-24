<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference_id')->nullable();
            $table->string('title');
            $table->text('title_trans')->nullable();
            $table->text('description')->nullable();
            $table->longText('description_trans')->nullable();
            $table->string('country')->nullable();
            $table->index('country');
            $table->longText('country_trans')->nullable();
            $table->string('dob')->nullable();
            $table->uuid('tenant_id');

            $table->uuid('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casts');
    }
}

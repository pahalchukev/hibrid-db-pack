<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateSubscribersSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('subscribers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('subscribers', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
    }
}

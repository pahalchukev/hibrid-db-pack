<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnTwoFactorSecretToUsersSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('users', function (Blueprint $table) {
            $table->dropColumn(['two_factor_secret']);
        });
    }
}

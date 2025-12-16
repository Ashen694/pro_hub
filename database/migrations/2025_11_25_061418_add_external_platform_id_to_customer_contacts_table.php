<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('external_platform_id')->nullable()->after('company_id');
            $table->foreign('external_platform_id')->references('platform_id')->on('external_platforms')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('customer_contacts', function (Blueprint $table) {
            $table->dropForeign(['external_platform_id']);
            $table->dropColumn('external_platform_id');
        });
    }
};
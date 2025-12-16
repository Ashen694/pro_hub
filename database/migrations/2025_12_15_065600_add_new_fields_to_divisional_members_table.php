<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('divisional_members', function (Blueprint $table) {
            $table->string('service_number')->nullable()->after('id');
            $table->string('group_name')->nullable()->after('contact_mobile');
            $table->date('date_of_birth')->nullable()->after('group_name');
            $table->string('calling_name')->nullable()->after('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('calling_name');
            $table->string('section')->nullable()->after('gender');
            $table->enum('member_type', ['divisional', 'view_only'])->default('divisional')->after('section');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisional_members', function (Blueprint $table) {
            $table->dropColumn([
                'service_number',
                'group_name', 
                'date_of_birth',
                'calling_name',
                'gender',
                'section',
                'member_type'
            ]);
        });
    }
};

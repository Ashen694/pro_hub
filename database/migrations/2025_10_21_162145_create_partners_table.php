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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('contact_person_title')->nullable();
            $table->string('contact_person_name');
            $table->string('contact_person_phone_1')->nullable();
            $table->string('contact_person_phone_2')->nullable();
            $table->string('contact_person_email');
            $table->string('contact_person_designation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};

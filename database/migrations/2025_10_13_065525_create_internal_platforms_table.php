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
        Schema::create('Internal_Platforms', function (Blueprint $table) {
            $table->id('ID'); // Primary Key
            $table->string('App_Name');
            $table->string('Developed_By')->nullable();
            $table->string('Developed_Team')->nullable();
            $table->date('StartDate')->nullable();
            $table->date('TargetDate')->nullable();
            $table->string('BitBucket')->nullable(); // Assuming this is a URL or name
            $table->string('BIT_bucket_repo')->nullable();
            $table->string('SDLCPhase')->nullable();
            $table->integer('PercentageDone')->nullable();
            $table->string('Status')->default('in-progress'); // Set a default status
            $table->date('StatusDate')->nullable();
            $table->string('Bus_Owner')->nullable();
            $table->string('App_Category'); // Main Application or Change Request
            $table->string('Scope')->nullable();
            $table->string('App_IP')->nullable();
            $table->string('App_URL')->nullable();
            $table->string('App_Users')->nullable();
            $table->date('UATDate')->nullable();
            $table->text('Integrated_apps')->nullable();
            $table->string('DR')->nullable(); // Can be True/False string or boolean
            $table->date('LaunchedDate')->nullable();
            $table->date('VADate')->nullable();
            $table->string('WAF')->nullable(); // Can be True/False string or boolean
            $table->string('APP_OP_Owner')->nullable();
            $table->string('APP_BUSINESS_Owner')->nullable();
            $table->decimal('Price', 15, 2)->nullable(); // For solution value
            $table->string('EndUserType')->nullable();
            $table->string('RequestNo')->nullable();
            $table->unsignedBigInteger('ParentProjectID')->nullable();
            $table->string('SLA')->nullable(); // Support Availability
            $table->string('BackupOfficer_1')->nullable();
            $table->string('BackupOfficer_2')->nullable();
            $table->string('MainAppID')->nullable();
            $table->date('SSLCertificateExpDate')->nullable();
            $table->string('UserSpecificSection')->nullable(); // New field from form
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Internal_Platforms');
    }
};
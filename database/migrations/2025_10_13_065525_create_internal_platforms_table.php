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
            $table->id('ID');
            $table->string('App_Name');
            $table->string('Developed_By')->nullable();
            $table->string('Developed_Team')->nullable();
            $table->date('StartDate')->nullable();
            $table->date('TargetDate')->nullable();
            $table->string('BitBucket')->nullable();
            $table->string('BIT_bucket_repo')->nullable();
            $table->string('SDLCPhase')->nullable();
            $table->integer('PercentageDone')->nullable();
            $table->string('Status')->default('in-progress');
            $table->date('StatusDate')->nullable();
            $table->string('Bus_Owner')->nullable();
            $table->string('App_Category');  
            $table->string('Scope')->nullable();
            $table->string('App_IP')->nullable();
            $table->string('App_URL')->nullable();
            $table->string('App_Users')->nullable();
            $table->date('UATDate')->nullable();
            $table->text('Integrated_apps')->nullable();
            $table->string('DR')->nullable();
            $table->date('LaunchedDate')->nullable();
            $table->date('VADate')->nullable();
            $table->string('WAF')->nullable();
            $table->string('APP_OP_Owner')->nullable();
            $table->string('APP_BUSINESS_Owner')->nullable();
            $table->decimal('Price', 15, 2)->nullable();
            $table->string('EndUserType')->nullable();
            $table->string('RequestNo')->nullable();
            
            // Foreign key to the ParentProject table (Application Group)
            $table->unsignedBigInteger('ParentProjectID')->nullable(); 

            $table->string('SLA')->nullable();
            $table->string('BackupOfficer_1')->nullable();
            $table->string('BackupOfficer_2')->nullable();

            // Foreign key for self-referencing (CR to Main App)
            $table->unsignedBigInteger('MainAppID')->nullable(); 
            
            $table->date('SSLCertificateExpDate')->nullable();
            $table->string('UserSpecificSection')->nullable();
            $table->timestamps();

            // Optional: Define foreign key constraints
            $table->foreign('ParentProjectID')->references('ParentProjectID')->on('ParentProject');
            $table->foreign('MainAppID')->references('ID')->on('Internal_Platforms');
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
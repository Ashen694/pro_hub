<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_s_d_l_cphases_table.php

    public function up(): void
    {
        Schema::create('SDLCphas', function (Blueprint $table) {  
            $table->id('ID');
            $table->string('Phase');
            $table->integer('OrderSeq'); 
            $table->timestamps();
        });
    }                                                              

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_d_l_cphases');
    }
};

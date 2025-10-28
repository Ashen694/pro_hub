<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('external_solutions', 'sdlc_stage')) {
            Schema::table('external_solutions', function (Blueprint $table) {
                $table->string('sdlc_stage')->nullable()->after('target_date');
            });

            // Copy existing values from dplo_stage to sdlc_stage
            DB::statement('UPDATE external_solutions SET sdlc_stage = dplo_stage');
        }
    }

    public function down(): void
    {
        // copy back just in case
        DB::statement('UPDATE external_solutions SET dplo_stage = sdlc_stage');

        Schema::table('external_solutions', function (Blueprint $table) {
            // attempt to drop, may require doctrine/dbal in some environments
            if (Schema::hasColumn('external_solutions', 'sdlc_stage')) {
                $table->dropColumn('sdlc_stage');
            }
        });
    }
};

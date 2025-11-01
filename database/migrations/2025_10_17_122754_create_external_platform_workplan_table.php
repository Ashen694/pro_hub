<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('external_platform_workplan', function (Blueprint $t) {
            $t->id();

            // Columns
            $t->unsignedBigInteger('workplan_id');
            $t->unsignedBigInteger('external_platform_id');

            $t->timestamps();

            // Short index names
            $t->index('workplan_id', 'epw_wp_idx');
            $t->index('external_platform_id', 'epw_ext_idx');

            // Short UNIQUE name for the pair (prevents duplicates)
            $t->unique(['workplan_id', 'external_platform_id'], 'epw_pair_unq');

            // Short FK names (avoid auto-generated 64+ char names)
            $t->foreign('workplan_id', 'epw_wp_fk')
              ->references('id')->on('workplans')
              ->cascadeOnUpdate()->cascadeOnDelete();

            $t->foreign('external_platform_id', 'epw_ext_fk')
              ->references('platform_id')->on('external_platforms')  
              ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void {
        // Drop constraints with their custom names first (safe on MySQL/MariaDB)
        Schema::table('external_platform_workplan', function (Blueprint $t) {
            // Wrap in try/catch not needed here; dropping by name is fine
            $t->dropForeign('epw_wp_fk');
            $t->dropForeign('epw_ext_fk');
            $t->dropUnique('epw_pair_unq');
            $t->dropIndex('epw_wp_idx');
            $t->dropIndex('epw_ext_idx');
        });

        Schema::dropIfExists('external_platform_workplan');
    }
};

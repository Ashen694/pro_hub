<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('internal_platform_workplan', function (Blueprint $t) {
            $t->id();

            // Columns
            $t->unsignedBigInteger('workplan_id');
            $t->unsignedBigInteger('internal_platform_id');

            $t->timestamps();

            // Short index names
            $t->index('workplan_id', 'ipw_wp_idx');
            $t->index('internal_platform_id', 'ipw_int_idx');

            // Prevent duplicate pairs (short unique name)
            $t->unique(['workplan_id', 'internal_platform_id'], 'ipw_pair_unq');

            // Short FK names
            $t->foreign('workplan_id', 'ipw_wp_fk')
              ->references('id')->on('workplans')
              ->cascadeOnUpdate()->cascadeOnDelete();

            // NOTE: internal platforms PK is platform_id
            $t->foreign('internal_platform_id', 'ipw_int_fk')
              ->references('ID')->on('Internal_Platforms')  
              ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void {
        // Drop named constraints/indexes first
        Schema::table('internal_platform_workplan', function (Blueprint $t) {
            $t->dropForeign('ipw_wp_fk');
            $t->dropForeign('ipw_int_fk');
            $t->dropUnique('ipw_pair_unq');
            $t->dropIndex('ipw_wp_idx');
            $t->dropIndex('ipw_int_idx');
        });

        Schema::dropIfExists('internal_platform_workplan');
    }
};

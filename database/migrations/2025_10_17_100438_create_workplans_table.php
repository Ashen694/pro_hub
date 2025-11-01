<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('workplans', function (Blueprint $t) {
            $t->id(); // ID

            // one of these must be set (enforced in validation + CHECK)
            // $t->foreignId('external_platform_id')->nullable()
            //   ->constrained('external_platforms', 'platform_id')
            //   ->cascadeOnUpdate()->nullOnDelete();

            // $t->foreignId('internal_platform_id')->nullable()
            //   ->constrained('internal_platforms', 'platform_id')
            //   ->cascadeOnUpdate()->nullOnDelete();

            $t->date('updated_on'); // UpdatedOn

            $t->foreignId('updated_by')
              ->constrained(table: 'Employee', column: 'Emp_ID')  
              ->cascadeOnUpdate()
              ->restrictOnDelete();

            $t->unsignedTinyInteger('week')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->text('workplan_desc')->nullable();
            $t->timestamps();
        });

        // MySQL 8.0.16+ supports CHECK; ignore failure gracefully
        // try {
        //     DB::statement("ALTER TABLE workplans
        //       ADD CONSTRAINT chk_workplan_week CHECK (week IS NULL OR week BETWEEN 1 AND 53)");
        //     DB::statement("ALTER TABLE workplans
        //       ADD CONSTRAINT chk_workplan_one_platform
        //       CHECK ( ((external_platform_id IS NOT NULL) + (internal_platform_id IS NOT NULL)) = 1 )");
        // } catch (\Throwable $e) {}
    }
    public function down(): void {
        Schema::dropIfExists('workplans');
    }
};

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trainee;
use Carbon\Carbon;

class UpdateTraineeStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trainees:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update trainee statuses based on training end dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking trainee statuses...');
        $today = Carbon::today();
        $this->info("Today's date: {$today->toDateString()}");
        
        // Get all active trainees with training end dates
        $activeTrainees = Trainee::where('status', 'active')
            ->whereNotNull('Training_EndDate')
            ->get();
            
        $this->info("Found {$activeTrainees->count()} active trainees with training end dates");
        
        $expiredTrainees = $activeTrainees->filter(function($trainee) use ($today) {
            $endDate = Carbon::parse($trainee->Training_EndDate);
            $this->line("Trainee: {$trainee->Trainee_Name} - End Date: {$endDate->toDateString()} - Expired: " . ($endDate->lte($today) ? 'YES' : 'NO'));
            return $endDate->lte($today); // Include today's date
        });

        $this->info("Found {$expiredTrainees->count()} expired trainees");

        $updatedCount = 0;

        foreach ($expiredTrainees as $trainee) {
            // Skip if already has payment info (should be paid status)
            if ($trainee->payment_start_date && $trainee->payment_end_date) {
                $this->line("Skipping {$trainee->Trainee_Name} - has payment info");
                continue;
            }

            // Update to inactive status
            $trainee->status = 'inactive';
            
            // Set terminated date if not already set
            if (!$trainee->terminated_date) {
                $trainee->terminated_date = $trainee->Training_EndDate;
            }
            
            // Set terminated reason if not already set
            if (!$trainee->terminated_reason) {
                $trainee->terminated_reason = 'Training period completed';
            }
            
            $trainee->save();
            $updatedCount++;
            
            $this->line("✓ Updated trainee: {$trainee->Trainee_Name} (ID: {$trainee->Trainee_ID}) - moved to inactive");
        }

        if ($updatedCount > 0) {
            $this->info("Successfully updated {$updatedCount} trainee(s) to inactive status.");
        } else {
            $this->info('No trainees need status updates.');
        }

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trainee;
use Carbon\Carbon;

class UpdateTraineeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trainees:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update trainee status to inactive when training period ends';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // Find all active trainees whose training end date has passed
        $expiredTrainees = Trainee::where('status', 'active')
            ->whereNotNull('Training_EndDate')
            ->whereDate('Training_EndDate', '<', $today)
            ->get();
        
        $count = 0;
        foreach ($expiredTrainees as $trainee) {
            $trainee->status = 'inactive';
            $trainee->save();
            $count++;
            
            $this->info("Updated trainee #{$trainee->Trainee_ID} ({$trainee->Trainee_Name}) to inactive status.");
        }
        
        if ($count > 0) {
            $this->info("Successfully updated {$count} trainee(s) to inactive status.");
        } else {
            $this->info("No trainees to update.");
        }
        
        return 0;
    }
}

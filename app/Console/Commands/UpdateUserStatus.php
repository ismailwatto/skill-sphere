<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate users who have paid but are currently inactive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting user status update...');

        $updatedCount = User::where('payment_status', 'paid')
            ->where('status', '!=', 'active') // Assuming 'active' is the active status
            ->update(['status' => 'active']);

        if ($updatedCount > 0) {
            $this->info("Successfully activated {$updatedCount} users.");
            Log::info("Scheduler: Activated {$updatedCount} users who paid.");
        } else {
            $this->info('No users required activation.');
        }
    }
}

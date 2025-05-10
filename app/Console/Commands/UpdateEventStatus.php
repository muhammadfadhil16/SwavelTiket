<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-event-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event statuses based on the current date and time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Update status to Ongoing
        Event::whereDate('date', $now->toDateString())
            ->whereTime('start_time', '<=', $now->toTimeString())
            ->whereTime('end_time', '>=', $now->toTimeString())
            ->where('status', 'Upcoming')
            ->update(['status' => 'Ongoing']);

        // Update status to Done
        Event::whereDate('date', '<=', $now->toDateString())
            ->whereTime('end_time', '<', $now->toTimeString())
            ->where('status', '!=', 'Done')
            ->update(['status' => 'Done']);
    }
}

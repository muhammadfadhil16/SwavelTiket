
<?php
use App\Console\Commands\UpdateEventStatus;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:update-event-status')->everyMinute();
    }
}

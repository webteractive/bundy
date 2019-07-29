<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\TimeLog;
use Illuminate\Support\Facades\DB;

class PurgeExtraLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time_log:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge all extra logs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::all()->each(function($user) {
            $this->line('Purging ' . $user->first_name . '\'s logs...');
            TimeLog::query()
                ->addSelect(DB::raw('DATE(started_at) as date'))
                ->of($user)
                ->latest('started_at')
                ->get()
                ->unique('date')
                ->each(function($timeline) use ($user) {
                    $this->line($timeline->date);
                    $first = TimeLog::query()
                                ->of($user)
                                ->whereDate('started_at', $timeline->date)
                                ->oldest('started_at')
                                ->first();
                    
                    TimeLog::query()
                        ->of($user)
                        ->whereDate('started_at', $timeline->date)
                        ->where('id', '<>', $first->id)
                        ->oldest('started_at')
                        ->delete();
                    
                    logger()->info($user->first_name . ': '. $first->started_at);
                });
            $this->info($user->first_name . '\'s logs has been purged successfully.');
        });
    }
}

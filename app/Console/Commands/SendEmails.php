<?php

namespace App\Console\Commands;

use App\Mail\WorkoutProgram;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $workoutPlan = WorkoutPlan::first();
        Mail::to('laupwing@gmail.com')->send(new WorkoutProgram([
            'groupedByDayWithFocusMuscles' => $workoutPlan->groupedByDayWithFocusMuscles,
            'days' => [],
            'workoutPlan' => [],
        ]));
    }
}

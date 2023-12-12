<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NewReportEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Report;

class NewReportMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_id;
    public $report_id;
    /**
     * Create a new job instance.
     */
    public function __construct($user_id,$report_id)
    {
        $this->user_id = $user_id;
        $this->report_id = $report_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $user = User::where('id',$this->user_id)->get();

        foreach ($user as $u) {
            $userEmail = $u->email;
        }

        $report = Report::where('id',$this->report_id)->get();

        foreach ($report as $r) {
            $reportID = $r->id;
            $reportType = $r->type;
            $reportSummary = $r->summary;
        }


        $data = [
            'type' => $reportType,
            'summary' => $reportSummary,
            'url' => env('APP_URL') . '/controlpanel/report/' . $reportID,
        ];

        Mail::to($userEmail)->send(new NewReportEmail($data));
        
    }
}

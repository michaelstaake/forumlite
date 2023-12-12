<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Settings;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Message;
use App\Models\User;
use App\Models\Report;
use Carbon\Carbon;
use App\Jobs\NewReportMail;

class ReportController extends Controller
{
    public function reportDiscussion(ReportRequest $request)
    {
        $discussion = Discussion::where('id', $request->id_of_reported)->first();

        if ($discussion) {
            $user = User::where('id', $discussion->member)->first();
            $report = new Report;
            $report->type = "discussion";
            $report->id_of_reported = $discussion->id;
            $report->summary = $request->who_reported.' has reported a discussion by '.$user->username;
            $report->content = '<a href="/member/'.$request->who_reported.'" target="_blank">'.$request->who_reported.'</a> has reported a discussion by <a href="/member/'.$user->username. '" target="_blank">'.$user->username.'</a> for reason: '.$request->reason.'<hr><strong> <a href="/discussion/'.$discussion->slug. '" target="_blank">'.$discussion->title.'</a></strong><br>'.$discussion->content;
            $report->who_reported = $request->who_reported;
            $report->status = "new";
            $report->save();

            $report = Report::where('id', $report->id)->first();

           //event(new NewReport($report));

           $url = '/discussion/'.$discussion->slug;
            return redirect($url);
        } else {
            abort(404);
        }
    }

    public function reportComment(ReportRequest $request)
    {
        $comment = Comment::where('id', $request->id_of_reported)->first();

        if ($comment) {
            $user = User::where('id', $comment->member)->first();
            $discussion = Discussion::where('id', $comment->discussion)->first();
            $report = new Report;
            $report->type = "comment";
            $report->id_of_reported = $comment->id;
            $report->summary = $request->who_reported.' has reported a comment by '.$user->username;
            $report->content = '<a href="/member/'.$request->who_reported.'" target="_blank">'.$request->who_reported.'</a> has reported a reply by <a href="/member/'.$user->username. '" target="_blank">'.$user->username.'</a> in discussion <a href="/discussion/'.$discussion->slug. '" target="_blank">'.$discussion->title.'</a> for reason: '.$request->reason.'<hr><strong> <a href="/discussion/'.$discussion->slug. '#comment-'.$comment->id.'" target="_blank">'.$discussion->title.'</a></strong><br>'.$comment->content;
            $report->who_reported = $request->who_reported;
            $report->status = "new";
            $report->save();

            $report = Report::where('id', $report->id)->first();

            //event(new NewReport($report));

            $url = '/discussion/'.$discussion->slug.'#comment-'.$comment->id;
            return redirect($url);
        } else {
            abort(404);
        }
    }

    public function reportMessage(ReportRequest $request)
    {
        $message = Message::where('id', $request->id_of_reported)->first();

        if ($message) {
            $user = User::where('id', $message->from)->first();
            $report = new Report;
            $report->type = "message";
            $report->id_of_reported = $message->id;
            $report->summary = $request->who_reported.' has reported a message from '.$user->username;
            $report->content = '<a href="/member/'.$request->who_reported.'" target="_blank">'.$request->who_reported.'</a> has reported a message from <a href="/member/'.$user->username. '" target="_blank">'.$user->username.'</a> for reason: '.$request->reason.'<hr><strong>'.$message->subject.'</strong><br>'.$message->content;
            $report->who_reported = $request->who_reported;
            $report->status = "new";
            $report->save();

            $report = Report::where('id', $report->id)->first();

            //event(new NewReport($report));

            $url = '/message/'.$message->id;
            return redirect($url);
        } else {
            abort(404);
        }
    }

    public function reportUser(ReportRequest $request)
    {
        $user = User::where('id', $request->id_of_reported)->first();

        if ($user) {
            $report = new Report;
            $report->type = "user";
            $report->id_of_reported = $user->id;
            $report->summary = $request->who_reported.' has reported user '.$user->username;
            $report->content = '<a href="/member/'.$request->who_reported.'" target="_blank">'.$request->who_reported.'</a> has reported user <a href="/member/'.$user->username. '" target="_blank">'.$user->username.'</a> for reason: '.$request->reason;
            $report->who_reported = $request->who_reported;
            $report->status = "new";
            $report->save();

            $report = Report::where('id', $report->id)->first();

            $report_recipients = User::where('group', 'admin')->orWhere('group', 'mod')->get();

            foreach ($report_recipients as $rr) {
                $user_id = $rr->id;
                $report_id = $report->id;
                NewReportMail::dispatch($user_id,$report_id);
            }

            $url = '/member/'.$user->username;
            return redirect($url);
        } else {
            abort(404);
        }
    }


}

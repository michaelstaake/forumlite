<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Comment;
use App\Models\Discussion;
use App\Models\Notification;

class NewNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $member;
    public $type;
    public $input;

    /**
     * Create a new job instance.
     */
    public function __construct($member,$type,$input)
    {
        $this->member = $member;
        $this->type = $type;
        $this->input = $input;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type === "comment") {
            $comment = Comment::where('id', $this->input)->first();
            $discussion = Discussion::where('id', $comment->discussion)->first();

            $user = User::where('id', $comment->member)->first();

            $notification = new Notification;
            $notification->member = $this->member;
            $notification->type = "reply";
            $notification->link = '/discussion/'.$discussion->slug.'#comment-'.$comment->id;
            $notification->content = 'New comment by '.$user->username.' in discussion "'.$discussion->title.'"';
            $notification->status = 'unread';
            $notification->save();
        }



    }
}

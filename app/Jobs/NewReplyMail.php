<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NewReplyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Comment;
use App\Models\Discussion;

class NewReplyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $member;
    public $comment;

    /**
     * Create a new job instance.
     */
    public function __construct($member,$comment)
    {
        $this->member = $member;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $user = User::where('id',$this->member)->get();

        foreach ($user as $u) {
            $userEmail = $u->email;
        }

        $commentGet = Comment::where('id',$this->comment)->get();

        foreach ($commentGet as $c) {
            $commentAuthor = $c->member;
            $commentDiscussion = $c->discussion;
        }

        $author = User::where('id',$commentAuthor)->get();

        foreach ($author as $a) {
            $authorUsername = $a->username;
        }

        $discussion = Discussion::where('id',$commentDiscussion)->get();

        foreach ($discussion as $d) {
            $discussionTitle = $d->title;
            $discussionSlug = $d->slug;
        }

        $data = [
            'title' => $discussionTitle,
            'author' => $authorUsername,
            'url' => env('APP_URL') . '/discussion/' . $discussionSlug . '#comment-' . $this->comment,
        ];

        Mail::to($userEmail)->send(new NewReplyEmail($data));
        
    }
}

<?php

namespace App\Listeners;

use App\Events\NewMessage;
use App\Mail\NewMessageEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendNewMessageMail
{
    /**
     * Handle the event.
     */
    public function handle(NewMessage $event)
    {
        $message = $event->message;

        $user = User::where('id',$message->to)->get();

        foreach ($user as $u) {
            $userEmail = $u->email;
        }

        Mail::to($userEmail)->send(new NewMessageEmail($message));
    }
}

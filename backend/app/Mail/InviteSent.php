<?php

namespace App\Mail;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteSent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $url;

    public function __construct(public Invitation $invitation, public User $user)
    {
        $this->url = 'http://localhost:3000/signup?token='.$invitation->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->invitation->email)
            ->subject('Invite to join the Foxes Knowledge service')
            ->markdown('emails.invitations.sent')
            ->text('emails.invitations.sent_plain')
            ->tag('invitation');
    }
}

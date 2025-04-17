<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Mail\InviteSent;
use App\Models\Invitation;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /**
     * Create an invitation and send email.
     */
    public function store(InvitationRequest $request): Response
    {
        if (! $invitation = Invitation::where('email', $request->email)->first()) {
            $invitation = Invitation::create([
                ...$request->validated(),
                'token' => str()->random(32),
            ]);
        }

        Mail::send(new InviteSent($invitation, Auth::user()));

        return response([], Response::HTTP_NO_CONTENT);
    }
}

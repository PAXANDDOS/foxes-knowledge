<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest\AttachmentStoreRequest;
use App\Http\Requests\AttachmentRequest\AttachmentUpdateRequest;
use App\Models\Attachment;
use Illuminate\Http\Response;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the attachments.
     */
    public function index(): Response
    {
        $attachments = Attachment::with('post')->get();

        return response($attachments);
    }

    /**
     * Store a newly created attachment in storage.
     */
    public function store(AttachmentStoreRequest $request): Response
    {
        $attachment = Attachment::create($request->validated());

        return response($attachment, Response::HTTP_CREATED);
    }

    /**
     * Display the attachment.
     */
    public function show(Attachment $attachment): Response
    {
        return response(Attachment::with('post')->find($attachment->id));
    }

    /**
     * Update the attachment in storage.
     */
    public function update(AttachmentUpdateRequest $request, Attachment $attachment): Response
    {
        $attachment->update($request->validated());

        return response($attachment, Response::HTTP_CREATED);
    }

    /**
     * Remove the attachment from storage.
     */
    public function destroy(Attachment $attachment): Response
    {
        $attachment->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}

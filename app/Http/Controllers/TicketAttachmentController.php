<?php

namespace App\Http\Controllers;

use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketAttachmentController extends Controller
{
    public function download(TicketAttachment $attachment)
    {
        $ticket = $attachment->ticket;

        $this->authorize('view', $ticket);

        if (!Storage::disk('attachments')->exists($attachment->path)) {
            abort(404, 'Attachment file not found.');
        }

        return Storage::disk('attachments')->download(
            $attachment->path,
            $attachment->name
        );
    }
}

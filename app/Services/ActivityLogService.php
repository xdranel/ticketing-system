<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\User;

class ActivityLogService
{

    public function log(
        Ticket $ticket,
        User $actor,
        string $action,
        string $description,
        array $metadata = [],
        string $visibility = 'internal'
    ): ActivityLog {
        return ActivityLog::create([
            'ticket_id' => $ticket->id,
            'ticket_reference' => $ticket->reference,

            'actor_id' => $actor->id,
            'actor_name' => $actor->name,
            'actor_role' => $actor->role,

            'action' => $action,
            'description' => $description,

            'visibility' => $visibility,
            'metadata' => $metadata,
        ]);
    }
}

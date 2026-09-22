<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'ticket_activities';

    protected $fillable = [
        'ticket_id',
        'ticket_reference',

        'actor_id',
        'actor_name',
        'actor_role',

        'action',
        'description',

        'visibility',
        'metadata',
    ];

    protected $casts = [
//        'metadata' => 'array',
    ];
}

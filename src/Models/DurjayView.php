<?php

namespace Durjaygp\DurjayViews\Models;

use Illuminate\Database\Eloquent\Model;

class DurjayView extends Model
{
    protected $table = 'durjay_views';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'type',
        'type_id',
        'user_id',
        'views',
    ];
}

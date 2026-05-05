<?php

namespace Durjaygp\DurjayViews\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class View extends Model
{
    protected $fillable = ['ip_address', 'user_agent', 'user_id'];

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}

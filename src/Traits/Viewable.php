<?php

namespace Durjaygp\DurjayViews\Traits;

use Durjaygp\DurjayViews\Models\View;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Request;
trait Viewable
{
    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function recordView(): void
    {
        $ip = request()->ip();
        
        // Anti-spam: Check if this IP viewed this specific model in the last 60 mins
        $alreadyViewed = $this->views()
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subMinutes(60))
            ->exists();

        if (!$alreadyViewed) {
            $this->views()->create([
                'ip_address' => $ip,
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function getViewCountAttribute(): int
    {
        return $this->views()->count();
    }

}

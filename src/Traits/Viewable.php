<?php

namespace Durjaygp\DurjayViews\Traits;

use Durjaygp\DurjayViews\Models\DurjayView;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Viewable
{
    /**
     * Get all of the views for the model.
     */
    public function durjayViews(): HasMany
    {
        return $this->hasMany(DurjayView::class, 'type_id')->where('type', strtolower(class_basename($this)));
    }

    /**
     * Record a view for this model.
     */
    public function recordDurjayView(): void
    {
        trackDurjayViews(strtolower(class_basename($this)), $this->getKey());
    }

    /**
     * Get the total view count.
     */
    public function getViewCountAttribute(): int
    {
        return $this->durjayViews()->sum('views');
    }
}

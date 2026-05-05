<?php

use Illuminate\Support\Facades\Auth;
use Durjaygp\DurjayViews\Models\DurjayView;

if (!function_exists('trackDurjayViews')) {
    function trackDurjayViews(string $type, int $typeId): void
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();
        $userId = Auth::id();

        $view = DurjayView::where('ip_address', $ipAddress)
            ->where('type', $type)
            ->where('type_id', $typeId)
            ->first();

        if ($view) {
            $view->increment('views');
        } else {
            DurjayView::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'type' => $type,
                'type_id' => $typeId,
                'user_id' => $userId,
                'views' => 1,
            ]);
        }
    }
}

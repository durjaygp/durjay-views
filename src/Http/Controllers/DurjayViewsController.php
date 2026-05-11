<?php

namespace Durjaygp\DurjayViews\Http\Controllers;

use Illuminate\Routing\Controller;
use Durjaygp\DurjayViews\Models\DurjayView;
use Illuminate\Support\Carbon;

class DurjayViewsController extends Controller
{
    // -----------------------------------------------------------------------
    // Shared data builder
    // -----------------------------------------------------------------------
    private function statsData(): array
    {
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayViews       = DurjayView::whereDate('created_at', $today)->sum('views');
        $yesterdayViews   = DurjayView::whereDate('created_at', $yesterday)->sum('views');
        $totalUniqueViews = DurjayView::distinct('ip_address')->count('ip_address');
        $todayUniqueViews = DurjayView::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address');

        $views = DurjayView::with('user')->orderBy('created_at', 'desc')->paginate(20);

        // Chart data for the last 7 days
        $chartData   = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[]   = (int) DurjayView::whereDate('created_at', $date)->sum('views');
        }

        return compact(
            'todayViews',
            'yesterdayViews',
            'totalUniqueViews',
            'todayUniqueViews',
            'views',
            'chartLabels',
            'chartData'
        );
    }

    // -----------------------------------------------------------------------
    // Public / auth-gated stats dashboard
    // -----------------------------------------------------------------------
    public function index()
    {
        return view('durjay-views::stats', $this->statsData());
    }

    // -----------------------------------------------------------------------
    // Admin dashboard — same data, separate view so it can be customised
    // independently. Protected by whatever middleware the user configured.
    // -----------------------------------------------------------------------
    public function admin()
    {
        // Falls back to the same stats view when no dedicated admin view exists.
        $view = view()->exists('durjay-views::admin')
            ? 'durjay-views::admin'
            : 'durjay-views::stats';

        return view($view, array_merge($this->statsData(), ['isAdmin' => true]));
    }
}

<?php

namespace Durjaygp\DurjayViews\Http\Controllers;

use Illuminate\Routing\Controller;
use Durjaygp\DurjayViews\Models\DurjayView;
use Illuminate\Support\Carbon;

class DurjayViewsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayViews = DurjayView::whereDate('created_at', $today)->sum('views');
        $yesterdayViews = DurjayView::whereDate('created_at', $yesterday)->sum('views');
        
        $totalUniqueViews = DurjayView::distinct('ip_address')->count('ip_address');
        $todayUniqueViews = DurjayView::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address');

        $views = DurjayView::with('user')->orderBy('created_at', 'desc')->paginate(20);

        // Chart data for the last 7 days
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[] = (int) DurjayView::whereDate('created_at', $date)->sum('views');
        }

        return view('durjay-views::stats', compact(
            'todayViews',
            'yesterdayViews',
            'totalUniqueViews',
            'todayUniqueViews',
            'views',
            'chartLabels',
            'chartData'
        ));
    }
}

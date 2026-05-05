<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Durjay Views Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Views Dashboard</h1>
            <p class="text-sm text-gray-500 font-medium">Real-time statistics</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center items-start">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Today Views</span>
                <span class="text-4xl font-black text-gray-900">{{ number_format($todayViews) }}</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center items-start">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Yesterday Views</span>
                <span class="text-4xl font-black text-gray-900">{{ number_format($yesterdayViews) }}</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center items-start">
                <span class="text-sm font-semibold text-indigo-500 uppercase tracking-wider mb-2">Today Unique</span>
                <span class="text-4xl font-black text-indigo-600">{{ number_format($todayUniqueViews) }}</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center items-start">
                <span class="text-sm font-semibold text-indigo-500 uppercase tracking-wider mb-2">Total Unique</span>
                <span class="text-4xl font-black text-indigo-600">{{ number_format($totalUniqueViews) }}</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold mb-4">Views Over Last 7 Days</h2>
            <div class="relative h-72 w-full">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xl font-bold">Recent Views Activity</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-white border-b border-gray-100">
                            <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Type / ID</th>
                            <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">User</th>
                            <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="p-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($views as $view)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-md uppercase tracking-wide">
                                        {{ $view->type ?? 'Unknown' }}
                                    </div>
                                    <span class="text-gray-600 font-medium">#{{ $view->type_id }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($view->user_id)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                            {{ substr(optional($view->user)->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ optional($view->user)->name ?? 'User #'.$view->user_id }}</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Guest
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-gray-500 font-medium">
                                {{ $view->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="p-4">
                                <span class="font-black text-gray-900">{{ $view->views }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                No view records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($views, 'hasPages') && $views->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $views->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('viewsChart').getContext('2d');
            const viewsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Views',
                        data: @json($chartData),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#111827',
                            padding: 12,
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 14 },
                            displayColors: false,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false,
                            },
                            ticks: {
                                precision: 0,
                                color: '#6b7280',
                                font: { size: 12, weight: '500' }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#6b7280',
                                font: { size: 12, weight: '500' }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>

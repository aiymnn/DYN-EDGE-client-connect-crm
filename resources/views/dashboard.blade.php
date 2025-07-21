<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Cards: Staff, Customers, Tickets, Interactions -->
            <div class="flex flex-wrap gap-4 mb-3">
                @can('admin')
                    <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                        <div class="flex flex-col items-center justify-center h-full">
                            <div class="text-sm text-gray-500">Staff</div>
                            <div class="text-2xl font-bold text-blue-700">{{ $totalStaff }}</div>
                        </div>
                    </div>
                @endcan
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Customers</div>
                        <div class="text-2xl font-bold text-green-700">{{ $totalCustomers }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Tickets</div>
                        <div class="text-2xl font-bold text-purple-700">{{ $totalTickets }}</div>
                    </div>
                </div>
                <div class="flex-1 min-w-[200px] bg-white p-4 rounded shadow">
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-sm text-gray-500">Interactions</div>
                        <div class="text-2xl font-bold text-pink-700">{{ $totalInteractions }}</div>
                    </div>
                </div>
            </div>

            <!-- Charts: Ticket Status & Interaction Types -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                <!-- Ticket Status Doughnut -->
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Ticket Status Overview</h3>
                    <canvas id="ticketStatusChart" class="w-full aspect-[4/3]"></canvas>
                </div>

                <!-- Interaction Type Doughnut -->
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Interactions by Type</h3>
                    <canvas id="interactionTypeChart" class="w-full aspect-[4/3]"></canvas>
                </div>
            </div>

            <!-- Bar Chart Row: Tickets Created Per Month with Year Filter -->
            <div class="bg-white p-4 rounded shadow mb-3">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-gray-700">Tickets Created Per Month</h3>
                    <select id="yearFilter"
                        class="min-w-20 border rounded px-3 py-1.5 text-sm focus:ring focus:ring-blue-200">
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>
                                {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <canvas id="ticketsPerMonthChart" class="w-full aspect-[4/3]"></canvas>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Recent Interactions -->
                <div class="bg-white p-4 rounded shadow mb-4 md:mb-0">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Recent Interactions</h3>
                        <div>
                            <a href="{{ route('interactions.index') }}"
                                class="text-gray-500 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <ul class="space-y-2">
                        @forelse($recentInteractions as $interaction)
                            <li
                                class="flex justify-between items-center p-3 bg-gray-50 rounded hover:bg-gray-100 transition">
                                <div class="flex items-center gap-2">
                                    <div>
                                        <div class="font-semibold">{{ $interaction->customer->name ?? 'Unknown' }}</div>
                                        @can('admin')
                                            <div class="text-xs text-gray-500">
                                                handled by:
                                                @if ($interaction->staff)
                                                    <a href="{{ route('users.show', ['user' => $interaction->staff]) }}"
                                                        class="text-blue-600 hover:underline">
                                                        {{ $interaction->staff->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-700">Unknown</span>
                                                @endif
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-xs
                            @switch($interaction->type)
                                @case('call') bg-green-100 text-green-800 @break
                                @case('email') bg-blue-100 text-blue-800 @break
                                @case('meeting') bg-purple-100 text-purple-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch">
                                        {{ ucfirst($interaction->type) }}
                                    </span>
                                    <div class="text-xs text-gray-500">
                                        {{ $interaction->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-500">No recent interactions.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Recent Tickets -->
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Recent Tickets</h3>
                        <div>
                            <a href="{{ route('tickets.index') }}"
                                class="text-gray-500 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <ul class="space-y-2">
                        @forelse($recentTickets as $ticket)
                            <li
                                class="flex justify-between items-center p-3 bg-gray-50 rounded hover:bg-gray-100 transition">
                                <div class="flex items-center gap-2">
                                    <div>
                                        <div class="font-semibold">{{ $ticket->title }}</div>
                                        <div class="text-xs text-gray-500">
                                            from:
                                            @if ($ticket->customer)
                                                <a href="{{ route('customers.show', ['customer' => $ticket->customer]) }}"
                                                    class="text-blue-600 hover:underline">
                                                    {{ $ticket->customer->name }}
                                                </a>
                                            @else
                                                <span class="text-gray-700">Unknown</span>
                                            @endif
                                        </div>

                                        @can('admin')
                                            <div class="text-xs text-gray-500">
                                                assigned to:
                                                @if ($ticket->staff)
                                                    <a href="{{ route('users.show', ['user' => $ticket->staff]) }}"
                                                        class="text-blue-600 hover:underline">
                                                        {{ $ticket->staff->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-700">Unknown</span>
                                                @endif
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-xs
                            {{ $ticket->status == 'open'
                                ? 'bg-green-100 text-green-800'
                                : ($ticket->status == 'in progress'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($ticket->status == 'resolved'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-gray-200 text-gray-800')) }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                    <div class="text-xs text-gray-400">
                                        {{ $ticket->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-500">No recent tickets.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Pending Follow-Ups -->
            <div class="bg-white p-4 rounded shadow mt-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Pending Follow-Ups</h3>
                    <div>
                        <a href="{{ route('tickets.index', ['status' => 'open']) }}"
                            class="text-gray-500 hover:text-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>
                </div>
                <ul class="space-y-2">
                    @forelse($pendingFollowUps as $ticket)
                        <li
                            class="flex justify-between items-center p-3 bg-gray-50 rounded hover:bg-gray-100 transition">
                            <div>
                                <div class="font-semibold text-gray-800">{{ $ticket->title }}</div>
                                <div class="text-xs text-gray-500">from : {{ $ticket->customer->name ?? 'Unknown' }}
                                </div>
                                <div class="text-xs text-gray-500">assigned to :
                                    {{ $ticket->staff->name ?? 'Unknown' }}
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-xs
                        {{ $ticket->status == 'open'
                            ? 'bg-green-100 text-green-800'
                            : ($ticket->status == 'in progress'
                                ? 'bg-yellow-100 text-yellow-800'
                                : 'bg-gray-200 text-gray-800') }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                                <div class="text-xs text-gray-400">{{ $ticket->created_at->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-500">No pending follow-ups.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Doughnut Chart: Ticket Status
        const ctxTicketStatus = document.getElementById('ticketStatusChart').getContext('2d');
        const ticketStatusChart = new Chart(ctxTicketStatus, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($doughnutTicketStatusCounts)),
                datasets: [{
                    data: @json(array_values($doughnutTicketStatusCounts)),
                    backgroundColor: ['#22c55e', '#eab308', '#3b82f6', '#9ca3af'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Doughnut Chart: Interaction Types
        const ctxInteractionType = document.getElementById('interactionTypeChart').getContext('2d');
        const interactionTypeChart = new Chart(ctxInteractionType, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($doughnutInteractionTypeCounts)),
                datasets: [{
                    data: @json(array_values($doughnutInteractionTypeCounts)),
                    backgroundColor: ['#f87171', '#60a5fa', '#a78bfa', '#34d399', '#fbbf24'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bar Chart: Tickets Per Month
        const ctxTicketsPerMonth = document.getElementById('ticketsPerMonthChart').getContext('2d');
        let ticketsPerMonthChart = new Chart(ctxTicketsPerMonth, {
            type: 'bar',
            data: {
                labels: @json(array_keys($barTicketsPerMonthCounts)),
                datasets: [{
                    label: 'Tickets',
                    data: @json(array_values($barTicketsPerMonthCounts)),
                    backgroundColor: [
                        '#3b82f6', '#22c55e', '#f97316', '#eab308',
                        '#8b5cf6', '#ec4899', '#0ea5e9', '#f43f5e',
                        '#14b8a6', '#facc15', '#6366f1', '#10b981'
                    ],
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Year Filter Event Listener
        document.getElementById('yearFilter').addEventListener('change', function() {
            const selectedYear = this.value;

            fetch(`{{ route('dashboard') }}?year=${selectedYear}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    ticketsPerMonthChart.data.labels = Object.keys(data);
                    ticketsPerMonthChart.data.datasets[0].data = Object.values(data);
                    ticketsPerMonthChart.update();
                });
        });
    </script>
</x-app-layout>

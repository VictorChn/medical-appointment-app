<div class="px-4 pt-6 max-w-full">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Calendario</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Calendario de Citas</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div id="calendar" wire:ignore></div>
    </div>

    <!-- Include FullCalendar CDN -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('livewire:initialized', function() {
            var calendarEl = document.getElementById('calendar');
            var eventsData = {!! $events !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                events: eventsData,
                eventClick: function(info) {
                    // Navigate to the consultation or edit page (for now let's just go to the index)
                    window.location.href = '/admin/appointments';
                }
            });

            calendar.render();
        });
    </script>
</div>

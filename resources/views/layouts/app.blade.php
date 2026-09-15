<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Routine Tracker' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="min-h-screen bg-gray-100 text-gray-900">

    <header class="bg-[#1e293b] border-b border-slate-700/50">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-4">

            <!-- Logo Badge -->
            <a href="{{ route('dashboard') }}"
                class="inline-block rounded-2xl bg-[#1e293b] px-5 py-2.5 text-lg font-black tracking-tight text-slate-100 border-2 border-slate-600/40 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.5),inset_2px_2px_4px_rgba(255,255,255,0.1),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                Routine Tracker
            </a>

            <!-- Navigation Buttons -->
            <nav class="flex gap-3 text-xs font-black uppercase tracking-wider">
                <a href="{{ route('dashboard') }}"
                    class="rounded-xl bg-[#1e293b] px-4 py-2 text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Dashboard
                </a>

                <a href="{{ route('routines') }}"
                    class="rounded-xl bg-[#1e293b] px-4 py-2 text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Routines
                </a>

                <a href="{{ route('calendar') }}"
                    class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Calendar
                </a>

                <a href="{{ route('availability') }}"
                    class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Availability
                </a>
                <a href="{{ route('history') }}"
                    class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    History
                </a>

                <a href="{{ route('progress') }}"
                    class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs
                    font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40
                    shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)]
                    transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50
                    active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Progress
                </a>

                <a href="{{ route('weekly-review') }}"
                    class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Weekly Review
                </a>

                <a href="{{ route('settings') }}"
                    class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Settings
                </a>
            </nav>

        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>

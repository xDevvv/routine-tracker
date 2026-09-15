<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-6xl space-y-8">

        <!-- Header Section -->
        <div>
            <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                {{ $today->format('l, F j, Y') }}
            </p>

            <h1 class="mt-1 text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Today's Plan
            </h1>

            <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                {{ $routines->count() }} routines
                <span class="mx-1 text-slate-600">•</span>
                {{ $totalMinutes }} minutes planned
            </p>
        </div>

        @if ($routines->isEmpty())

            <!-- Empty State Container -->
            <div
                class="rounded-[2.5rem] bg-[#1e293b] p-12 text-center border-4 border-slate-700/40 shadow-[inset_6px_6px_12px_rgba(0,0,0,0.6),inset_-6px_-6px_12px_rgba(51,65,85,0.3)]">
                <h2 class="text-base font-black text-slate-200">
                    No routines scheduled today
                </h2>

                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Add a routine and assign it to today's day.
                </p>
            </div>
        @else
            <!-- Routines Grid -->
            <div class="grid gap-6 md:grid-cols-2">

                @foreach ($routines as $routine)
                    <div
                        class="flex flex-col justify-between rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[12px_12px_24px_rgba(0,0,0,0.6),-12px_-12px_24px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)] transition-transform duration-150 hover:-translate-y-0.5">

                        <div>
                            <!-- Header Info -->
                            <div class="flex items-start justify-between gap-4">

                                <div>
                                    <h2
                                        class="font-black text-slate-100 text-lg drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                        {{ $routine->name }}
                                    </h2>

                                    @if ($routine->category)
                                        <p class="mt-0.5 text-xs font-bold text-slate-400">
                                            {{ $routine->category }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Clay Pill Badge -->
                                <span
                                    class="rounded-xl bg-[#1e293b] px-3 py-1 text-[10px] font-black uppercase tracking-wider text-slate-300 border border-slate-600/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                    {{ ucfirst($routine->priority) }}
                                </span>

                            </div>

                            <!-- Duration & Type -->
                            <div class="mt-4 flex gap-4 text-xs font-black uppercase tracking-wider text-slate-400">

                                <span class="inline-flex items-center gap-1">
                                    ⏱️ {{ $routine->duration_minutes }} min
                                </span>

                                <span class="inline-flex items-center gap-1">
                                    📌 {{ ucfirst($routine->type) }}
                                </span>

                            </div>

                            @php
                                $nextTask = $routine->tasks->first();
                            @endphp

                            <!-- Next Task Inset Box -->
                            @if ($nextTask)
                                <div
                                    class="mt-5 rounded-2xl bg-[#1e293b] p-4 border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">

                                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-500">
                                        Next task
                                    </p>

                                    <p class="mt-1 font-black text-slate-200 text-sm">
                                        @if ($nextTask->day_number)
                                            <span class="text-indigo-400">Day {{ $nextTask->day_number }}</span> —
                                        @endif

                                        {{ $nextTask->title }}
                                    </p>

                                    @if ($nextTask->estimated_minutes)
                                        <p class="mt-1 text-[10px] font-black uppercase tracking-wider text-slate-500">
                                            {{ $nextTask->estimated_minutes }} minutes
                                        </p>
                                    @endif

                                </div>
                            @else
                                <div
                                    class="mt-5 rounded-2xl bg-[#1e293b] p-4 border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                    <p class="text-xs font-bold text-slate-500">
                                        No incomplete tasks.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Link Button -->
                        <div class="mt-6 pt-2">
                            <a href="{{ route('routines.tasks', $routine) }}"
                                class="inline-block rounded-xl bg-[#1e293b] px-4 py-2.5 text-xs font-black uppercase tracking-wider text-indigo-400 border-2 border-indigo-900/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.3),inset_1.5px_1.5px_3px_rgba(255,255,255,0.08),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-indigo-300 hover:border-indigo-700/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                                View tasks →
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>

        @endif

    </div>
</div>

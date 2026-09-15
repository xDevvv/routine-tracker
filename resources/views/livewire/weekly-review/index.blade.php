<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-6xl space-y-8">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                    Weekly Review
                </h1>

                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                    Review your routine performance for the week.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <button wire:click="previousWeek"
                    class="rounded-xl bg-[#1e293b] px-4 py-2.5 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Previous
                </button>

                <button wire:click="currentWeek"
                    class="rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.25),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    This Week
                </button>

                <button wire:click="nextWeek"
                    class="rounded-xl bg-[#1e293b] px-4 py-2.5 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                    Next
                </button>

            </div>

        </div>

        <div
            class="inline-block rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-indigo-400 border border-slate-700/80 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.6),inset_-2px_-2px_4px_rgba(51,65,85,0.3)]">
            📅 {{ $review['week_start']->format('M d, Y') }} - {{ $review['week_end']->format('M d, Y') }}
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

            <div
                class="rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[16px_16px_32px_rgba(0,0,0,0.7),-14px_-14px_28px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Planned
                </p>

                <p class="mt-2 text-3xl font-black text-slate-200">
                    {{ intdiv($review['planned_minutes'], 60) }}h
                    {{ $review['planned_minutes'] % 60 }}m
                </p>
            </div>

            <div
                class="rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[16px_16px_32px_rgba(0,0,0,0.7),-14px_-14px_28px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Actual
                </p>

                <p class="mt-2 text-3xl font-black text-indigo-400 drop-shadow-[0_2px_6px_rgba(99,102,241,0.3)]">
                    {{ intdiv($review['actual_minutes'], 60) }}h
                    {{ $review['actual_minutes'] % 60 }}m
                </p>
            </div>

            <div
                class="rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[16px_16px_32px_rgba(0,0,0,0.7),-14px_-14px_28px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Completion
                </p>

                <p class="mt-2 text-3xl font-black text-emerald-400 drop-shadow-[0_2px_6px_rgba(52,211,153,0.3)]">
                    {{ $review['completion_rate'] }}%
                </p>
            </div>

            <div
                class="rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[16px_16px_32px_rgba(0,0,0,0.7),-14px_-14px_28px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Sessions
                </p>

                <p class="mt-2 text-3xl font-black text-slate-100">
                    {{ $review['completed_sessions'] + $review['stopped_sessions'] }}
                </p>

                <p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    <span class="text-emerald-400">{{ $review['completed_sessions'] }}</span> completed /
                    <span class="text-rose-400">{{ $review['stopped_sessions'] }}</span> stopped
                </p>
            </div>

        </div>

        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-6 sm:p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

            <div class="mb-6">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Daily Breakdown
                </h2>
            </div>

            <div class="space-y-4">

                @foreach ($review['daily'] as $day)
                    <div
                        class="flex items-center justify-between rounded-2xl bg-[#1e293b] p-5 border-2 border-slate-700/60 shadow-[8px_8px_16px_rgba(0,0,0,0.5),-8px_-8px_16px_rgba(51,65,85,0.25)] transition-all">

                        <div>
                            <p class="text-sm font-black text-slate-100">
                                {{ $day['date']->format('D') }}
                            </p>

                            <p class="mt-0.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                {{ $day['date']->format('M d') }}
                            </p>
                        </div>

                        <div class="text-right">

                            <p class="text-sm font-black text-indigo-400">
                                {{ intdiv($day['actual_minutes'], 60) }}h
                                {{ $day['actual_minutes'] % 60 }}m
                            </p>

                            <p class="mt-0.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Planned:
                                {{ intdiv($day['planned_minutes'], 60) }}h
                                {{ $day['planned_minutes'] % 60 }}m
                            </p>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-6 sm:p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

            <div class="mb-6">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Routine Performance
                </h2>
            </div>

            @if ($review['by_routine']->isEmpty())

                <div
                    class="rounded-2xl bg-[#1e293b] p-8 text-center border-2 border-slate-700/40 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-500">
                        No sessions recorded this week.
                    </p>
                </div>
            @else
                <div class="space-y-4">

                    @foreach ($review['by_routine'] as $item)
                        <div
                            class="flex items-center justify-between rounded-2xl bg-[#1e293b] p-5 border-2 border-slate-700/60 shadow-[8px_8px_16px_rgba(0,0,0,0.5),-8px_-8px_16px_rgba(51,65,85,0.25)] transition-all">

                            <div>
                                <p class="text-sm font-black text-slate-100">
                                    {{ $item['routine']->name }}
                                </p>

                                <p class="mt-0.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    {{ $item['sessions'] }} sessions
                                </p>
                            </div>

                            <div class="text-right">

                                <p class="text-sm font-black text-indigo-400">
                                    {{ intdiv($item['actual_minutes'], 60) }}h
                                    {{ $item['actual_minutes'] % 60 }}m
                                </p>

                                <p class="mt-0.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    Planned:
                                    {{ intdiv($item['planned_minutes'], 60) }}h
                                    {{ $item['planned_minutes'] % 60 }}m
                                </p>

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </div>
</div>

<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-6xl space-y-8">

        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Progress
            </h1>

            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                Track how much time you're actually spending on your routines.
            </p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <div
                class="rounded-[2.5rem] bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Today
                </p>

                <p class="mt-2 text-4xl font-black text-indigo-400 drop-shadow-[0_2px_6px_rgba(99,102,241,0.3)]">
                    {{ intdiv($today['minutes'], 60) }}h
                    {{ $today['minutes'] % 60 }}m
                </p>

                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    {{ $today['sessions'] }} sessions
                </p>
            </div>

            <div
                class="rounded-[2.5rem] bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                    This Week
                </p>

                <p class="mt-2 text-4xl font-black text-indigo-400 drop-shadow-[0_2px_6px_rgba(99,102,241,0.3)]">
                    {{ intdiv($week['minutes'], 60) }}h
                    {{ $week['minutes'] % 60 }}m
                </p>

                <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    {{ $week['sessions'] }} sessions
                </p>
            </div>

        </div>

        {{-- Planned vs Actual --}}
        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

            <h2 class="text-xs font-black uppercase tracking-wider text-slate-400">
                Planned vs Actual
            </h2>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

                <div
                    class="rounded-2xl bg-[#1e293b] p-5 border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                        Planned
                    </p>

                    <p class="mt-1 text-2xl font-black text-slate-200">
                        {{ intdiv($plannedVsActual['planned'], 60) }}h
                        {{ $plannedVsActual['planned'] % 60 }}m
                    </p>
                </div>

                <div
                    class="rounded-2xl bg-[#1e293b] p-5 border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                    <p class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                        Actual
                    </p>

                    <p class="mt-1 text-2xl font-black text-emerald-400">
                        {{ intdiv($plannedVsActual['actual'], 60) }}h
                        {{ $plannedVsActual['actual'] % 60 }}m
                    </p>
                </div>

            </div>

        </div>

        {{-- Routine Progress --}}
        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-6 sm:p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">
            <div class="mb-6">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-400">
                    Time by Routine
                </h2>
            </div>

            @if ($byRoutine->isEmpty())

                <div
                    class="rounded-2xl bg-[#1e293b] p-8 text-center border-2 border-slate-700/40 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-500">
                        No session data yet.
                    </p>
                </div>
            @else
                <div class="space-y-4">

                    @foreach ($byRoutine as $item)
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

                            <p class="text-sm font-black text-indigo-400">
                                {{ intdiv($item['minutes'], 60) }}h
                                {{ $item['minutes'] % 60 }}m
                            </p>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </div>
</div>

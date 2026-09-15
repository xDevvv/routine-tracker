<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-6xl space-y-8">

        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Session History
            </h1>

            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                Review the time you've spent on your routines.
            </p>
        </div>

        <div class="max-w-xs">
            <label for="routine" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                Filter by routine
            </label>

            <select id="routine" wire:model.live="routineId"
                class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-xs font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all cursor-pointer">
                <option value="" class="bg-[#1e293b] text-slate-300">All routines</option>

                @foreach ($routines as $routine)
                    <option value="{{ $routine->id }}" class="bg-[#1e293b] text-slate-200">
                        {{ $routine->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if ($sessions->isEmpty())

            <div
                class="rounded-[2.5rem] bg-[#1e293b] p-12 text-center border-4 border-slate-700/40 shadow-[inset_6px_6px_12px_rgba(0,0,0,0.6),inset_-6px_-6px_12px_rgba(51,65,85,0.3)]">
                <p class="text-xs font-black uppercase tracking-wider text-slate-500">
                    No completed sessions yet.
                </p>
            </div>
        @else
            <div
                class="rounded-[2.5rem] bg-[#1e293b] p-4 sm:p-6 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)] overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-separate border-spacing-y-3">

                        <thead>
                            <tr>
                                <th class="px-5 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Routine
                                </th>

                                <th class="px-5 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Date
                                </th>

                                <th class="px-5 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Planned
                                </th>

                                <th class="px-5 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Actual
                                </th>

                                <th class="px-5 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Paused
                                </th>

                                <th class="px-5 py-2 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Status
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($sessions as $session)
                                <tr class="group">

                                    <td
                                        class="rounded-l-2xl bg-[#1e293b] px-5 py-4 text-xs font-black text-slate-100 border-y-2 border-l-2 border-slate-700/60 shadow-[inset_2px_2px_4px_rgba(255,255,255,0.05),inset_0_-2px_4px_rgba(0,0,0,0.4)]">
                                        {{ $session->routine->name }}
                                    </td>

                                    <td
                                        class="bg-[#1e293b] px-5 py-4 text-xs font-bold text-slate-400 border-y-2 border-slate-700/60 shadow-[inset_0_2px_4px_rgba(255,255,255,0.05),inset_0_-2px_4px_rgba(0,0,0,0.4)] whitespace-nowrap">
                                        {{ $session->started_at->format('M d, Y H:i') }}
                                    </td>

                                    <td
                                        class="bg-[#1e293b] px-5 py-4 text-xs font-bold text-slate-300 border-y-2 border-slate-700/60 shadow-[inset_0_2px_4px_rgba(255,255,255,0.05),inset_0_-2px_4px_rgba(0,0,0,0.4)] whitespace-nowrap">
                                        {{ $session->planned_minutes }} min
                                    </td>

                                    <td
                                        class="bg-[#1e293b] px-5 py-4 text-xs font-black text-indigo-400 border-y-2 border-slate-700/60 shadow-[inset_0_2px_4px_rgba(255,255,255,0.05),inset_0_-2px_4px_rgba(0,0,0,0.4)] whitespace-nowrap">
                                        {{ $session->actual_minutes }} min
                                    </td>

                                    <td
                                        class="bg-[#1e293b] px-5 py-4 text-xs font-bold text-slate-400 border-y-2 border-slate-700/60 shadow-[inset_0_2px_4px_rgba(255,255,255,0.05),inset_0_-2px_4px_rgba(0,0,0,0.4)] whitespace-nowrap">
                                        {{ $session->paused_minutes }} min
                                    </td>

                                    <td
                                        class="rounded-r-2xl bg-[#1e293b] px-5 py-4 border-y-2 border-r-2 border-slate-700/60 shadow-[inset_-2px_2px_4px_rgba(255,255,255,0.05),inset_0_-2px_4px_rgba(0,0,0,0.4)] whitespace-nowrap">
                                        @if ($session->status === 'completed')
                                            <span
                                                class="inline-block rounded-xl bg-[#1e293b] px-3 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-400 border border-emerald-800/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                                Completed
                                            </span>
                                        @else
                                            <span
                                                class="inline-block rounded-xl bg-[#1e293b] px-3 py-1 text-[10px] font-black uppercase tracking-wider text-rose-400 border border-rose-800/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                                Stopped
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </div>
</div>

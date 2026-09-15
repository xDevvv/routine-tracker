<div wire:poll.1000ms="tick" class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-xl">

        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

            <div class="mb-6">
                <h2 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                    Focus Timer
                </h2>

                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                    Focus on one routine at a time.
                </p>
            </div>

            <div class="mb-5">
                <label for="routine" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                    Routine
                </label>

                <select id="routine" wire:model.live="routineId" @disabled($running)
                    class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                    <option value="" class="bg-[#1e293b] text-slate-400">
                        Select a routine
                    </option>

                    @foreach ($routines as $routine)
                        <option value="{{ $routine->id }}" class="bg-[#1e293b] text-slate-200">
                            {{ $routine->name }} — {{ $routine->duration_minutes }} min
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-8">
                <label for="duration" class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                    Duration
                </label>

                <select id="duration" wire:model.live="durationMinutes" @disabled($running)
                    class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                    <option value="15" class="bg-[#1e293b] text-slate-200">15 minutes</option>
                    <option value="25" class="bg-[#1e293b] text-slate-200">25 minutes</option>
                    <option value="30" class="bg-[#1e293b] text-slate-200">30 minutes</option>
                    <option value="45" class="bg-[#1e293b] text-slate-200">45 minutes</option>
                    <option value="60" class="bg-[#1e293b] text-slate-200">60 minutes</option>
                    <option value="90" class="bg-[#1e293b] text-slate-200">90 minutes</option>
                    <option value="120" class="bg-[#1e293b] text-slate-200">120 minutes</option>
                </select>
            </div>

            <div
                class="mb-8 rounded-4xl bg-[#1e293b] py-8 text-center border-2 border-slate-700/80 shadow-[inset_6px_6px_12px_rgba(0,0,0,0.7),inset_-6px_-6px_12px_rgba(51,65,85,0.3)]">
                <div
                    class="text-6xl sm:text-7xl font-black font-mono tracking-wider text-indigo-400 drop-shadow-[0_2px_8px_rgba(99,102,241,0.3)]">
                    {{ sprintf('%02d:%02d', intdiv($remainingSeconds, 60), $remainingSeconds % 60) }}
                </div>

                <div class="mt-3 text-xs font-black uppercase tracking-wider text-slate-400">
                    @if ($running)
                        <span class="inline-flex items-center gap-1 text-emerald-400">
                            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                            Focus session in progress
                        </span>
                    @elseif ($paused)
                        <span class="text-amber-400">⏸️ Timer paused</span>
                    @elseif ($remainingSeconds > 0)
                        <span>Ready to continue</span>
                    @else
                        <span>Ready to start</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4">

                @if (!$running && !$paused)
                    <button wire:click="start" @disabled(!$routineId)
                        class="rounded-2xl bg-indigo-600 px-6 py-3.5 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)] disabled:opacity-40 disabled:cursor-not-allowed disabled:transform-none">
                        Start
                    </button>
                @endif

                @if ($running)
                    <button wire:click="pause"
                        class="rounded-2xl bg-amber-600 px-6 py-3.5 text-xs font-black uppercase tracking-wider text-white border-2 border-amber-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-amber-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                        Pause
                    </button>

                    <button wire:click="stop"
                        class="rounded-2xl bg-rose-600 px-6 py-3.5 text-xs font-black uppercase tracking-wider text-white border-2 border-rose-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-rose-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                        Stop
                    </button>
                @endif

                @if ($paused)
                    <button wire:click="resume"
                        class="rounded-2xl bg-emerald-600 px-6 py-3.5 text-xs font-black uppercase tracking-wider text-white border-2 border-emerald-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-emerald-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                        Resume
                    </button>

                    <button wire:click="stop"
                        class="rounded-2xl bg-rose-600 px-6 py-3.5 text-xs font-black uppercase tracking-wider text-white border-2 border-rose-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-rose-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                        Stop
                    </button>
                @endif

                @if (!$running && $remainingSeconds > 0)
                    <button wire:click="resetTimer"
                        class="rounded-2xl bg-[#1e293b] px-6 py-3.5 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.1),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                        Reset
                    </button>
                @endif

            </div>

            <div x-data="{ show: false }" x-on:timer-completed.window="show = true" x-show="show" x-cloak
                class="mt-6 rounded-2xl bg-[#1e293b] p-4 text-center text-xs font-black uppercase tracking-wider text-emerald-400 border-2 border-emerald-900/50 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                🎉 Focus session completed.
            </div>

        </div>

    </div>
</div>

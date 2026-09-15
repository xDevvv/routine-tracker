<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-3xl space-y-8">

        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Settings
            </h1>

            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                Configure how your daily schedule is planned.
            </p>
        </div>

        @if ($message)
            <div
                class="rounded-2xl bg-[#1e293b] border-2 border-emerald-500/40 px-5 py-4 text-xs font-black uppercase tracking-wider text-emerald-400 shadow-[8px_8px_16px_rgba(0,0,0,0.6),-8px_-8px_16px_rgba(51,65,85,0.3),inset_2px_2px_4px_rgba(255,255,255,0.05)] flex items-center gap-3">
                <span class="text-base">✓</span>
                <span>{{ $message }}</span>
            </div>
        @endif

        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

            <h2 class="mb-6 text-xs font-black uppercase tracking-wider text-slate-400">
                Scheduling
            </h2>

            <div class="space-y-6">

                {{-- Day Start --}}
                <div>
                    <label for="dayStart" class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">
                        Default Day Start
                    </label>

                    <input id="dayStart" type="time" wire:model="dayStart"
                        class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-xs font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all scheme:dark">

                    @error('dayStart')
                        <p class="mt-2 text-[10px] font-black uppercase tracking-wider text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Day End --}}
                <div>
                    <label for="dayEnd" class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">
                        Default Day End
                    </label>

                    <input id="dayEnd" type="time" wire:model="dayEnd"
                        class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-xs font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all scheme:dark">

                    @error('dayEnd')
                        <p class="mt-2 text-[10px] font-black uppercase tracking-wider text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Minimum Block --}}
                <div>
                    <label for="minimumBlockMinutes"
                        class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">
                        Minimum Scheduling Block
                    </label>

                    <select id="minimumBlockMinutes" wire:model="minimumBlockMinutes"
                        class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-xs font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all cursor-pointer">
                        <option value="5" class="bg-[#1e293b] text-slate-200">5 minutes</option>
                        <option value="10" class="bg-[#1e293b] text-slate-200">10 minutes</option>
                        <option value="15" class="bg-[#1e293b] text-slate-200">15 minutes</option>
                        <option value="30" class="bg-[#1e293b] text-slate-200">30 minutes</option>
                        <option value="60" class="bg-[#1e293b] text-slate-200">60 minutes</option>
                    </select>

                    @error('minimumBlockMinutes')
                        <p class="mt-2 text-[10px] font-black uppercase tracking-wider text-rose-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Auto Schedule Toggle Card --}}
                <div
                    class="flex items-center justify-between rounded-2xl bg-[#1e293b] p-5 border-2 border-slate-700/60 shadow-[8px_8px_16px_rgba(0,0,0,0.5),-8px_-8px_16px_rgba(51,65,85,0.25)]">

                    <div>
                        <p class="text-xs font-black text-slate-100 uppercase tracking-wider">
                            Automatic Scheduling
                        </p>

                        <p class="mt-0.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            Allow Optimize My Day to automatically place routines.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input type="checkbox" wire:model="autoSchedule" class="peer sr-only">

                        <div class="h-7 w-14 rounded-full bg-[#1e293b] border-2 border-slate-700/80 shadow-

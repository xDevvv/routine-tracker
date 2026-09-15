<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-4xl space-y-8">

        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Availability
            </h1>

            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                Define the hours when you are generally available.
            </p>
        </div>

        @if (session('success'))
            <div
                class="rounded-2xl bg-[#1e293b] p-4 text-xs font-black uppercase tracking-wider text-emerald-400 border-2 border-emerald-900/50 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                ✨ {{ session('success') }}
            </div>
        @endif

        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-6 sm:p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)] space-y-4">

            @foreach ($days as $day => $name)
                <div
                    class="rounded-2xl bg-[#1e293b] p-5 border-2 border-slate-700/60 shadow-[8px_8px_16px_rgba(0,0,0,0.5),-8px_-8px_16px_rgba(51,65,85,0.25)] transition-all">

                    <div class="grid items-center gap-4 md:grid-cols-4">

                        <div class="font-black text-slate-100 text-base drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                            {{ $name }}
                        </div>

                        <label class="inline-flex cursor-pointer items-center gap-3 select-none">
                            <div
                                class="relative flex h-6 w-6 items-center justify-center rounded-xl bg-[#1e293b] border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                <input type="checkbox" wire:model="availability.{{ $day }}.active"
                                    class="peer sr-only">
                                <span
                                    class="h-3 w-3 rounded-md bg-indigo-500 opacity-0 transition-opacity peer-checked:opacity-100"></span>
                            </div>

                            <span class="text-xs font-black uppercase tracking-wider text-slate-300">
                                Available
                            </span>
                        </label>

                        <div>
                            <label class="mb-1.5 block text-[10px] font-black uppercase tracking-wider text-slate-400">
                                Start
                            </label>

                            <input type="time" wire:model="availability.{{ $day }}.start_time"
                                @disabled(!$availability[$day]['active'])
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-2.5 text-xs font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all disabled:opacity-40 disabled:cursor-not-allowed scheme:dark">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-[10px] font-black uppercase tracking-wider text-slate-400">
                                End
                            </label>

                            <input type="time" wire:model="availability.{{ $day }}.end_time"
                                @disabled(!$availability[$day]['active'])
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-2.5 text-xs font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all disabled:opacity-40 disabled:cursor-not-allowed scheme:dark">
                        </div>

                    </div>

                </div>
            @endforeach

        </div>

        <div class="flex justify-end pt-2">

            <button wire:click="save"
                class="rounded-2xl bg-indigo-600 px-6 py-3.5 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                Save Availability
            </button>

        </div>

    </div>
</div>

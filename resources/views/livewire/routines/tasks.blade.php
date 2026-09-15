<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-5xl space-y-8">

        <!-- Back Link & Header -->
        <div>
            <a href="{{ route('routines') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5">
                ← Back to Routines
            </a>

            <div class="mt-4">
                <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                    {{ $routine->name }}
                </h1>

                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                    Manage tasks for this routine.
                </p>
            </div>
        </div>

        <!-- Add Task Form Container -->
        <div
            class="rounded-[2.5rem] bg-[#1e293b] p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

            <h2 class="mb-6 text-xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                Add Task
            </h2>

            <form wire:submit="addTask" class="space-y-5">

                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                        Task
                    </label>

                    <input type="text" wire:model="title" placeholder="Meet the Terminal"
                        class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500">

                    @error('title')
                        <p
                            class="mt-2 text-xs font-bold text-rose-400 bg-rose-950/40 p-2.5 rounded-xl border border-rose-800/50 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.5)]">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                        Description
                    </label>

                    <textarea wire:model="description" rows="3" placeholder="Learn pwd, ls, cd, clear, history and man."
                        class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500 resize-none"></textarea>
                </div>

                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Day Number
                        </label>

                        <input type="number" wire:model="day_number" min="1" placeholder="1"
                            class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Estimated Minutes
                        </label>

                        <input type="number" wire:model="estimated_minutes" min="1" placeholder="60"
                            class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500">
                    </div>

                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="rounded-2xl bg-indigo-600 px-6 py-3 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                        Add Task
                    </button>
                </div>

            </form>

        </div>

        <!-- Task List Stack -->
        <div class="space-y-4">

            @forelse ($tasks as $task)
                <div
                    class="flex items-start justify-between rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[12px_12px_24px_rgba(0,0,0,0.6),-12px_-12px_24px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)] transition-transform duration-150 hover:-translate-y-0.5">

                    <div class="flex items-start gap-4">

                        <!-- Custom Clay Checkbox Button -->
                        <button wire:click="toggleComplete({{ $task->id }})"
                            class="mt-1 flex h-7 w-7 items-center justify-center rounded-xl bg-[#1e293b] border-2 border-slate-600/40 transition-all {{ $task->completed_at ? 'bg-indigo-600 text-white shadow-[inset_2px_2px_4px_rgba(0,0,0,0.6)]' : 'shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] text-transparent' }}">
                            <span class="text-xs font-black">✓</span>
                        </button>

                        <div>

                            <div class="flex items-center gap-3">

                                @if ($task->day_number)
                                    <span
                                        class="rounded-xl bg-[#1e293b] px-3 py-1 text-[10px] font-black uppercase tracking-wider text-slate-300 border border-slate-600/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                        Day {{ $task->day_number }}
                                    </span>
                                @endif

                                <h3
                                    class="font-black text-slate-100 text-base drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)] {{ $task->completed_at ? 'line-through opacity-40' : '' }}">
                                    {{ $task->title }}
                                </h3>

                            </div>

                            @if ($task->description)
                                <p class="mt-2 text-xs font-bold text-slate-400">
                                    {{ $task->description }}
                                </p>
                            @endif

                            @if ($task->estimated_minutes)
                                <p class="mt-2 text-[10px] font-black uppercase tracking-wider text-slate-500">
                                    ⏱️ Estimated: {{ $task->estimated_minutes }} minutes
                                </p>
                            @endif

                        </div>

                    </div>

                    <!-- Delete Action Button -->
                    <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?"
                        class="rounded-xl bg-[#1e293b] px-3.5 py-2 text-xs font-black uppercase tracking-wider text-rose-400 border-2 border-rose-900/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.3),inset_1.5px_1.5px_3px_rgba(255,255,255,0.08),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all hover:-translate-y-0.5 hover:text-rose-300 hover:border-rose-800/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                        Delete
                    </button>

                </div>

            @empty

                <!-- Empty State -->
                <div
                    class="rounded-[2.5rem] bg-[#1e293b] p-12 text-center border-4 border-slate-700/40 shadow-[inset_6px_6px_12px_rgba(0,0,0,0.6),inset_-6px_-6px_12px_rgba(51,65,85,0.3)]">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-500">
                        No tasks yet.
                    </p>
                </div>
            @endforelse

        </div>

    </div>
</div>

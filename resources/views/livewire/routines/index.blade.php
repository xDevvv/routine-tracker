<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-6xl space-y-8">

        <!-- Header -->
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
                    Routines
                </h1>
                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                    Manage your recurring activities
                </p>
            </div>

            <button wire:click="create"
                class="rounded-2xl bg-indigo-600 px-5 py-3 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.5),-4px_-4px_10px_rgba(255,255,255,0.1),inset_2px_2px_4px_rgba(255,255,255,0.3),inset_-3px_-3px_6px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                + New Routine
            </button>
        </div>

        @if ($showForm)
            <!-- Form Container -->
            <div
                class="rounded-[2.5rem] bg-[#263347] p-8 border-2 border-white/10 shadow-[18px_18px_36px_rgba(15,23,42,0.8),-14px_-14px_28px_rgba(255,255,255,0.05),inset_3px_3px_6px_rgba(255,255,255,0.1),inset_-3px_-3px_6px_rgba(0,0,0,0.4)]">

                <h2 class="mb-6 text-xl font-black tracking-tight text-white drop-shadow-[0_1px_2px_rgba(0,0,0,0.5)]">
                    {{ $editingId ? 'Edit Routine' : 'New Routine' }}
                </h2>

                <form wire:submit="save" class="space-y-5">

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Name
                        </label>

                        <input type="text" wire:model="name" placeholder="Linux Challenge"
                            class="w-full rounded-2xl bg-[#1d2736] px-4 py-3 text-sm font-bold text-slate-200 outline-none border-2 border-white/5 shadow-[inset_4px_4px_8px_rgba(10,15,26,0.8),inset_-3px_-3px_6px_rgba(255,255,255,0.05)] focus:border-indigo-500 transition-all placeholder:text-slate-500">

                        @error('name')
                            <p
                                class="mt-2 text-xs font-bold text-rose-300 bg-rose-950/60 p-2.5 rounded-xl border border-rose-500/30 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.4)]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Category
                        </label>

                        <input type="text" wire:model="category" placeholder="Study"
                            class="w-full rounded-2xl bg-[#1d2736] px-4 py-3 text-sm font-bold text-slate-200 outline-none border-2 border-white/5 shadow-[inset_4px_4px_8px_rgba(10,15,26,0.8),inset_-3px_-3px_6px_rgba(255,255,255,0.05)] focus:border-indigo-500 transition-all placeholder:text-slate-500">
                    </div>

                    <div class="grid gap-5 md:grid-cols-3">

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Duration (minutes)
                            </label>

                            <input type="number" wire:model="duration_minutes" min="1"
                                class="w-full rounded-2xl bg-[#1d2736] px-4 py-3 text-sm font-bold text-slate-200 outline-none border-2 border-white/5 shadow-[inset_4px_4px_8px_rgba(10,15,26,0.8),inset_-3px_-3px_6px_rgba(255,255,255,0.05)] focus:border-indigo-500 transition-all">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Priority
                            </label>

                            <select wire:model="priority"
                                class="w-full rounded-2xl bg-[#1d2736] px-4 py-3 text-sm font-bold text-slate-200 outline-none border-2 border-white/5 shadow-[inset_4px_4px_8px_rgba(10,15,26,0.8),inset_-3px_-3px_6px_rgba(255,255,255,0.05)] focus:border-indigo-500 transition-all">
                                <option value="low" class="bg-[#1d2736]">Low</option>
                                <option value="normal" class="bg-[#1d2736]">Normal</option>
                                <option value="high" class="bg-[#1d2736]">High</option>
                                <option value="critical" class="bg-[#1d2736]">Critical</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Type
                            </label>

                            <select wire:model="type"
                                class="w-full rounded-2xl bg-[#1d2736] px-4 py-3 text-sm font-bold text-slate-200 outline-none border-2 border-white/5 shadow-[inset_4px_4px_8px_rgba(10,15,26,0.8),inset_-3px_-3px_6px_rgba(255,255,255,0.05)] focus:border-indigo-500 transition-all">
                                <option value="fixed" class="bg-[#1d2736]">Fixed</option>
                                <option value="flexible" class="bg-[#1d2736]">Flexible</option>
                                <option value="optional" class="bg-[#1d2736]">Optional</option>
                            </select>
                        </div>

                    </div>

                    <label class="flex items-center gap-3 pt-1 cursor-pointer select-none">
                        <input type="checkbox" wire:model="active"
                            class="h-5 w-5 rounded-lg appearance-none bg-[#1d2736] border-2 border-white/10 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.6),inset_-2px_-2px_4px_rgba(255,255,255,0.05)] checked:bg-indigo-600 checked:shadow-[inset_1px_1px_2px_rgba(0,0,0,0.4)] transition-all">

                        <span class="text-xs font-black uppercase tracking-wider text-slate-400">
                            Active
                        </span>
                    </label>
                    <div>
                        <label class="mb-2 block text-sm font-medium">
                            Days
                        </label>

                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                            @foreach ([1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'] as $day => $name)
                                <label class="flex items-center gap-2 rounded-lg border p-3">
                                    <input type="checkbox" wire:model="selectedDays" value="{{ $day }}">

                                    <span class="text-sm">
                                        {{ $name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>


                    <div class="flex gap-3 pt-3">

                        <button type="submit"
                            class="rounded-2xl bg-indigo-600 px-6 py-3 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.5),-4px_-4px_10px_rgba(255,255,255,0.1),inset_2px_2px_4px_rgba(255,255,255,0.3),inset_-3px_-3px_6px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                            Save
                        </button>

                        <button type="button" wire:click="cancel"
                            class="rounded-2xl bg-[#263347] px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-white/10 shadow-[6px_6px_12px_rgba(15,23,42,0.7),-4px_-4px_10px_rgba(255,255,255,0.05),inset_2px_2px_4px_rgba(255,255,255,0.1),inset_-2px_-2px_4px_rgba(0,0,0,0.3)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.5)]">
                            Cancel
                        </button>

                    </div>

                </form>
            </div>
        @endif


        <!-- Routines Cards Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($routines as $routine)
                <div
                    class="flex flex-col justify-between rounded-4xl bg-[#263347] p-6 border-2 border-white/10 shadow-[14px_14px_28px_rgba(15,23,42,0.8),-10px_-10px_20px_rgba(255,255,255,0.04),inset_2px_2px_4px_rgba(255,255,255,0.08),inset_-2px_-2px_4px_rgba(0,0,0,0.3)] transition-transform duration-200 hover:-translate-y-1">

                    <div>
                        <div class="mb-4 flex items-start justify-between gap-2">

                            <div>
                                <h2 class="font-black text-white text-lg drop-shadow-[0_1px_2px_rgba(0,0,0,0.5)]">
                                    {{ $routine->name }}
                                </h2>

                                @if ($routine->category)
                                    <p class="text-xs font-bold text-slate-400 tracking-wide uppercase mt-0.5">
                                        {{ $routine->category }}
                                    </p>
                                @endif
                            </div>

                            <span
                                class="rounded-xl bg-[#1d2736] px-3 py-1.5 text-[10px] font-black uppercase tracking-wider text-slate-300 border border-white/10 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.5),inset_-1px_-1px_2px_rgba(255,255,255,0.05)]">
                                {{ ucfirst($routine->priority) }}
                            </span>

                        </div>

                        <div class="space-y-1.5 text-xs font-bold text-slate-400">
                            <p class="flex items-center gap-2">
                                <span class="opacity-70">⏱️</span> {{ $routine->duration_minutes }} minutes
                            </p>

                            @if ($routine->days->count())
                                <p class="flex items-center gap-2">
                                    <span class="opacity-70">📌</span> {{ ucfirst($routine->type) }}
                                </p>
                            @endif

                            <p class="flex items-center gap-2">
                                <span class="opacity-70">⚡</span> {{ $routine->active ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2 pt-3 border-t border-slate-700/50">

                        <a href="{{ route('routines.tasks', $routine) }}"
                            class="inline-block rounded-xl bg-[#1e293b] px-3.5 py-2 text-xs font-black uppercase tracking-wider text-slate-200 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.4),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                            Tasks
                        </a>

                        <button wire:click="edit({{ $routine->id }})"
                            class="flex-1 rounded-xl bg-[#263347] py-2 text-xs font-black uppercase tracking-wider text-slate-300 border border-white/10 shadow-[4px_4px_8px_rgba(15,23,42,0.6),-3px_-3px_6px_rgba(255,255,255,0.04),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1)] transition-all hover:-translate-y-0.5 hover:text-white active:translate-y-0.5">
                            Edit
                        </button>

                        <button wire:click="delete({{ $routine->id }})" wire:confirm="Delete this routine?"
                            class="flex-1 rounded-xl bg-rose-950/40 py-2 text-xs font-black uppercase tracking-wider text-rose-400 border border-rose-500/30 shadow-[4px_4px_8px_rgba(15,23,42,0.6),-3px_-3px_6px_rgba(255,255,255,0.04),inset_1.5px_1.5px_3px_rgba(255,255,255,0.1)] transition-all hover:-translate-y-0.5 hover:bg-rose-900/50 active:translate-y-0.5">
                            Delete
                        </button>

                    </div>

                </div>
            @empty
                <!-- Empty State -->
                <div
                    class="col-span-full rounded-[2.5rem] bg-[#263347] p-12 text-center border-2 border-white/5 shadow-[inset_6px_6px_12px_rgba(10,15,26,0.8),inset_-6px_-6px_12px_rgba(255,255,255,0.04)]">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">
                        No routines yet.
                    </p>

                    <button wire:click="create"
                        class="mt-4 rounded-2xl bg-indigo-600 px-5 py-2.5 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[5px_5px_10px_rgba(0,0,0,0.5),-4px_-4px_8px_rgba(255,255,255,0.08)] transition-all hover:-translate-y-0.5 active:translate-y-0.5">
                        Create your first routine
                    </button>
                </div>
            @endforelse

        </div>

    </div>
</div>

<div class="min-h-screen bg-[#1e293b] p-6 text-slate-200 font-sans selection:bg-indigo-500/30">
    <div class="mx-auto max-w-6xl space-y-8">

        <!-- Top Header Bar -->
        <div class="flex items-center justify-between gap-4">

            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                    Calendar
                </h1>

                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                    Manage your fixed commitments.
                </p>
            </div>

            <button wire:click="create"
                class="rounded-2xl bg-indigo-600 px-5 py-3 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                + New Event
            </button>

        </div>

        @if ($showForm)
            <!-- Event Form Container -->
            <div
                class="rounded-[2.5rem] bg-[#1e293b] p-8 border-4 border-slate-600/30 shadow-[20px_20px_40px_rgba(0,0,0,0.7),-18px_-18px_36px_rgba(51,65,85,0.35),inset_4px_4px_8px_rgba(255,255,255,0.08),inset_-4px_-4px_8px_rgba(0,0,0,0.5)]">

                <h2
                    class="mb-6 text-xl font-black tracking-tight text-slate-100 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                    {{ $editingId ? 'Edit Event' : 'New Event' }}
                </h2>

                <form wire:submit="save" class="space-y-5">

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Title
                        </label>

                        <input type="text" wire:model="title" placeholder="School"
                            class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500">

                        @error('title')
                            <p
                                class="mt-2 text-xs font-bold text-rose-400 bg-rose-950/40 p-2.5 rounded-xl border border-rose-800/50 shadow-[inset_2px_2px_4px_rgba(0,0,0,0.5)]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid gap-5 md:grid-cols-3">

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Date
                            </label>

                            <input type="date" wire:model="date"
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all scheme:dark">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Start
                            </label>

                            <input type="time" wire:model="start_time"
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all scheme:dark">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                End
                            </label>

                            <input type="time" wire:model="end_time"
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all scheme:dark">
                        </div>

                    </div>

                    <div class="grid gap-5 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Location
                            </label>

                            <input type="text" wire:model="location" placeholder="Room 201"
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                                Meeting Link
                            </label>

                            <input type="url" wire:model="meeting_link" placeholder="https://..."
                                class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all placeholder:text-slate-500">
                        </div>

                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Priority
                        </label>

                        <select wire:model="priority"
                            class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all">
                            <option value="low" class="bg-[#1e293b] text-slate-200">Low</option>
                            <option value="normal" class="bg-[#1e293b] text-slate-200">Normal</option>
                            <option value="high" class="bg-[#1e293b] text-slate-200">High</option>
                            <option value="critical" class="bg-[#1e293b] text-slate-200">Critical</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-400">
                            Notes
                        </label>

                        <textarea wire:model="notes" rows="3"
                            class="w-full rounded-2xl bg-[#1e293b] px-4 py-3 text-sm font-bold text-slate-100 outline-none border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)] focus:border-indigo-500 transition-all resize-none"></textarea>
                    </div>

                    <!-- Inset Clay Checkbox -->
                    <label class="inline-flex cursor-pointer items-center gap-3 select-none">
                        <div
                            class="relative flex h-6 w-6 items-center justify-center rounded-xl bg-[#1e293b] border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                            <input type="checkbox" wire:model="recurring" class="peer sr-only">
                            <span
                                class="h-3 w-3 rounded-md bg-indigo-500 opacity-0 transition-opacity peer-checked:opacity-100"></span>
                        </div>

                        <span class="text-xs font-black uppercase tracking-wider text-slate-300">
                            Recurring event
                        </span>
                    </label>

                    <div class="flex gap-3 pt-2">

                        <button type="submit"
                            class="rounded-2xl bg-indigo-600 px-6 py-3 text-xs font-black uppercase tracking-wider text-white border-2 border-indigo-400/30 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.25),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:bg-indigo-500 active:translate-y-0.5 active:shadow-[inset_4px_4px_8px_rgba(0,0,0,0.6)]">
                            Save
                        </button>

                        <button type="button" wire:click="cancel"
                            class="rounded-2xl bg-[#1e293b] px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[6px_6px_14px_rgba(0,0,0,0.6),-6px_-6px_14px_rgba(51,65,85,0.4),inset_2px_2px_4px_rgba(255,255,255,0.1),inset_-2px_-2px_4px_rgba(0,0,0,0.4)] transition-all duration-150 hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                            Cancel
                        </button>

                    </div>

                </form>

            </div>
        @endif

        <!-- Event List Stack -->
        <div class="space-y-4">

            @forelse ($events as $event)
                <div
                    class="flex flex-col justify-between rounded-4xl bg-[#1e293b] p-6 border-4 border-slate-600/30 shadow-[12px_12px_24px_rgba(0,0,0,0.6),-12px_-12px_24px_rgba(51,65,85,0.35),inset_3px_3px_6px_rgba(255,255,255,0.08),inset_-3px_-3px_6px_rgba(0,0,0,0.5)] transition-transform duration-150 hover:-translate-y-0.5">

                    <div>
                        <!-- Header & Priority Badge -->
                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <h2 class="font-black text-slate-100 text-lg drop-shadow-[0_1px_2px_rgba(0,0,0,0.8)]">
                                    {{ $event->title }}
                                </h2>

                                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-400">
                                    {{ $event->date->format('l, F j, Y') }}
                                </p>
                            </div>

                            <!-- Clay Pill Badge -->
                            <span
                                class="rounded-xl bg-[#1e293b] px-3 py-1 text-[10px] font-black uppercase tracking-wider text-slate-300 border border-slate-600/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                {{ ucfirst($event->priority) }}
                            </span>

                        </div>

                        <!-- Time & Location Details -->
                        <div
                            class="mt-3 text-xs font-black uppercase tracking-wider text-slate-400 flex flex-wrap items-center gap-2">
                            <span>⏱️ {{ substr($event->start_time, 0, 5) }} –
                                {{ substr($event->end_time, 0, 5) }}</span>

                            @if ($event->location)
                                <span class="text-slate-600">•</span>
                                <span>📍 {{ $event->location }}</span>
                            @endif
                        </div>

                        <!-- Meeting Link -->
                        @if ($event->meeting_link)
                            <div class="mt-3">
                                <a href="{{ $event->meeting_link }}" target="_blank"
                                    class="inline-block rounded-xl bg-[#1e293b] px-3.5 py-1.5 text-xs font-black uppercase tracking-wider text-indigo-400 border border-indigo-900/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)] transition-all hover:-translate-y-0.5 hover:text-indigo-300">
                                    🔗 Meeting link
                                </a>
                            </div>
                        @endif

                        <!-- Notes Inset Box -->
                        @if ($event->notes)
                            <div
                                class="mt-4 rounded-2xl bg-[#1e293b] p-4 border-2 border-slate-700/80 shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6),inset_-3px_-3px_6px_rgba(51,65,85,0.3)]">
                                <p class="text-xs font-bold text-slate-400">
                                    {{ $event->notes }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Card Actions -->
                    <div class="mt-6 flex gap-3 pt-2">

                        <button wire:click="edit({{ $event->id }})"
                            class="rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-slate-300 border-2 border-slate-600/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.3),inset_1.5px_1.5px_3px_rgba(255,255,255,0.08),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all hover:-translate-y-0.5 hover:text-white hover:border-slate-500/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                            Edit
                        </button>

                        <button wire:click="delete({{ $event->id }})" wire:confirm="Delete this event?"
                            class="rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-rose-400 border-2 border-rose-900/40 shadow-[4px_4px_10px_rgba(0,0,0,0.6),-4px_-4px_10px_rgba(51,65,85,0.3),inset_1.5px_1.5px_3px_rgba(255,255,255,0.08),inset_-1.5px_-1.5px_3px_rgba(0,0,0,0.4)] transition-all hover:-translate-y-0.5 hover:text-rose-300 hover:border-rose-800/50 active:translate-y-0.5 active:shadow-[inset_3px_3px_6px_rgba(0,0,0,0.6)]">
                            Delete
                        </button>

                    </div>

                </div>

            @empty

                <!-- Empty State -->
                <div
                    class="rounded-[2.5rem] bg-[#1e293b] p-12 text-center border-4 border-slate-700/40 shadow-[inset_6px_6px_12px_rgba(0,0,0,0.6),inset_-6px_-6px_12px_rgba(51,65,85,0.3)]">

                    <p class="text-xs font-black uppercase tracking-wider text-slate-500">
                        No events yet.
                    </p>

                    <button wire:click="create"
                        class="mt-4 rounded-xl bg-[#1e293b] px-4 py-2 text-xs font-black uppercase tracking-wider text-indigo-400 border border-indigo-900/40 shadow-[3px_3px_6px_rgba(0,0,0,0.5),-3px_-3px_6px_rgba(51,65,85,0.3)] transition-all hover:-translate-y-0.5 hover:text-indigo-300">
                        Add your first event
                    </button>

                </div>
            @endforelse

        </div>

    </div>
</div>

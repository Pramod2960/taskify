<div class="w-full px-10  mx-auto p-6 bg-white shadow-md rounded mt-5">
    @if ($task)
        <form wire:submit.prevent="save" class="text-sm">
            <div class="mb-4">

                <div class="flex gap-5 pb-1 justify-between">
                    <button wire:click="back"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md border border-blue-200 hover:bg-blue-100 hover:text-blue-700 transition-all duration-200">
                        ← Back
                    </button>
                    <div>
                        @if (session()->has('message'))
                            <span
                                class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full uppercase">
                                {{ session('message') }}
                            </span>
                        @endif
                    </div>
                    <div class="flex gap-5">
                        <span
                            class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full uppercase">
                            {{ $task->project->name }}
                        </span>
                        <span
                            class="inline-block px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full uppercase">
                            {{ $task->assigner->name }}
                        </span>
                        <span
                            class="inline-block px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-full uppercase">
                            {{ \Carbon\Carbon::parse($task->start_date)->format('d M') }}
                        </span>
                    </div>
                </div>
                <input type="text" value="{{ $task->title }}" wire:model="title"
                    class=" w-full rounded px-3 py-2 text-sm font-semibold  {{ $isEdit ? 'border-' : 'border-none' }}">
                @error('title')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <div class=" flex justify-between">
                    {{-- <label class="block text-sm font-medium mb-1 opacity-50 uppercase">Task
                    </label> --}}
                    <div class="flex gap-2 ">
                        <span>
                            Total words:
                        </span>
                        <h1 x-text="$wire.body.length"></h1>
                    </div>
                </div>

                <div class="h-48 mb-10 overflow-scroll" wire:ignore>
                    <input id="x" type="hidden" wire:model="body" value="{{ $task->body }}" name="body">
                    <trix-editor input="x" class="h-44 border-none"
                        x-on:trix-change="$wire.body = $event.target.value">
                    </trix-editor>
                </div>
                @error('body')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    <span wire:loading.delay>Saving...</span>
                    <span wire:loading.remove.delay>Save</span>
                </button>
                <button type="button" wire:click="markComplete('completed')"
                    class="bg-green-200 text-black px-4 py-2 rounded"
                    wire:confirm="Are you sure you want to mark this as completed?">
                    Mark as completed
                </button>
                <button type="button" wire:click="markComplete('pending')"
                    class="bg-slate-400 text-white px-4 py-2 rounded">
                    Mark as Pending
                </button>
                <button type="button" wire:click="markComplete('watching')"
                    class="bg-slate-400 text-white px-4 py-2 rounded">
                    Mark as Watching
                </button>
                <button type="button" wire:click="markDelete({{ $task->id }})"
                    wire:confirm="Are you sure you want to delete this post?"
                    class=" text-white px-4 py-2 rounded">
                    <img src="{{ asset('icons/trash-2.svg') }}" alt="trash" class="w-4 h-4 fill-rose-500">
                </button>
            </div>

        </form>
    @else
        <p class="text-gray-500">Task not found.</p>
    @endif
</div>



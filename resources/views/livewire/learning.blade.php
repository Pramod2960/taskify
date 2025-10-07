<div class="w-full px-10 h-screen p-6 bg-white rounded text-sm mt-2" x-data="{ showModal: false }">
    <div class="flex justify-between items-center mb-2">
        <div>
            <h2 class="text-xl font-semibold">All Learning Task</h2>
        </div>
        <div class="flex gap-2 items-center">
            <div>
                <input wire:model.live.debounce.300ms="search" placeholder="Search by Title"
                    class="rounded-lg p-1 px-2 text-sm border" />
            </div>
            <div class="flex gap-2">
                <button wire:click="clearFilter" class="bg-slate-300 text-black px-4 py-1 rounded">
                    Clear Filter
                </button>
                <button @click="showModal = true" class="bg-blue-600 text-white px-4 py-1 rounded">
                    Add New Task
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Category</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $index => $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('task.show', $task->id) }}" wire:navigate
                                class="{{ $task->status === 'completed' ? 'text-gray-500 hover:underline' : 'text-blue-600 hover:underline' }}">
                                {{ $task->title }}
                            </a>
                        </td>
                        <td class="px-4 py-1 border text-center text-sm">
                            <span
                                class="
                                    inline-block px-2 py-1 text-xs font-semibold rounded-full uppercase
                                    @if (strtolower($task->status) === 'new') text-rose-500 bg-rose-100 
                                    @elseif(strtolower($task->status) === 'completed') text-gray-700 bg-gray-100 opacity-60
                                    @elseif(strtolower($task->status) === 'overdue') text-red-700 bg-red-100
                                    @else text-blue-600 bg-blue-100 @endif
                                ">
                                {{ $task->status ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-1 border text-center text-sm  {{ $task->status === 'completed' ? 'text-gray-500' :''}} ">
                            {{ $task->category ?? '—' }}
                        </td>
                        <td class="px-4 py-1 border text-center text-sm">
                            @if ($task->status === 'completed')
                            @else
                                <button wire:click="markAsComplete({{ $task->id }})"
                                    class="px-3 py-1 text-sm font-medium text-gray-500 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition">
                                    Mark Complete
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ✅ Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0  px-10 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white w-full min-w-full max-w-lg rounded-lg shadow-lg p-6 relative">
            <!-- Close button -->
            <button @click="showModal = false"
                class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl font-bold">
                &times;
            </button>

            <h2 class="text-lg font-semibold mb-4">Add New Task</h2>

            <!-- Livewire form -->
            <form wire:submit.prevent="save" class="text-sm space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <textarea type="text" wire:model="title" class="w-full border rounded px-3 py-2 text-sm" rows="9">
                    </textarea>
                    @error('title')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Category</label>
                    <input type="text" wire:model="category" class="w-full border rounded px-3 py-2 text-sm">
                    @error('category')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="showModal = false"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                        Cancel
                    </button>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        <span wire:loading>Saving...</span>
                        <span wire:loading.remove>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @script
        <script>
            document.addEventListener('livewire:load', () => {
                Livewire.on('task-saved', () => {
                    document.querySelector('[x-data]').__x.$data.showModal = false;
                    $wire.refresh();
                });
            });
        </script>
    @endscript
</div>

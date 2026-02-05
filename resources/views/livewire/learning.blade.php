<div class="w-full px-10 h-full p-6 bg-white rounded text-sm mt-2" x-data="{ showModal: false }">
    <nav class="flex mb-4 text-sm text-gray-600" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <!-- Home -->
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L2 8h2v8h4v-4h4v4h4V8h2L10 2z" />
                    </svg>
                    Home
                </a>
            </li>

            <!-- Divider -->
            <li>
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </li>

            <!-- Projects -->
            <li>
                <a href="{{ route('learning.portal') }}" class="hover:text-blue-600">
                    Projects
                </a>
            </li>

            <!-- Divider -->
            <li>
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </li>

            <!-- Current Page -->
            <li aria-current="page">
                <span class="font-medium text-gray-900">
                    {{ $project_name ?? 'Learning' }}
                </span>
            </li>


        </ol>
    </nav>

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold"><span class="text-blue-600 font-bold">{{ $project_name }}</span>
        </h2>

        <div class="flex flex-wrap items-center justify-center p-1.5 rounded-full text-xs">
            <div class="flex items-center">
                <img class="size-7 rounded-full border-3 border-white" src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=50" alt="userImage1">
                <img class="size-7 rounded-full border-3 border-white -translate-x-2" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=50" alt="userImage2">
                <img class="size-7 rounded-full border-3 border-white -translate-x-4" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=50&h=50&auto=format&fit=crop" alt="userImage3">
            </div>
            @foreach($this->userAssignToThisProject as $user)
            <pre>{{ $user->name }}, </pre>
            @endforeach
        </div>

        <div class="flex flex-row gap-2">
            <div class=" flex gap-2 justify-center items-center rounded-xl border border-red-200 bg-red-100 p-2 shadow-sm">
                <p class="text-sm font-medium text-red-700">Pending</p>
                <p class=" text-2xl font-bold text-red-800">
                    {{ $this->count['not_completed'] }}
                </p>
            </div>

            <div class="flex gap-2 justify-center opacity-50 items-center rounded-xl border border-green-200 bg-green-50 p-2 shadow-sm">
                <p class="text-sm font-medium text-green-700">Completed</p>
                <p class=" text-2xl font-bold text-green-800">
                    {{ $this->count['completed'] }}
                </p>
            </div>
        </div>


        <div class="flex gap-2 items-center">
            <input wire:model.debounce.300ms="search" placeholder="Search by Title" class="rounded-lg p-1 px-2 text-sm border" />
            <button wire:click="clearFilter" class="bg-slate-300 text-black px-4 py-1 rounded">
                Clear Filter
            </button>
            <button wire:click="handleAddNewTask" class="bg-blue-600 text-white px-4 py-1 rounded">
                Add New Task
            </button>
            @hasanyrole('superadmin')
            <button wire:click="deleteProject" wire:confirm="Are you sure you want to delete this project?" class="bg-rose-600 text-white px-4 py-1 rounded">
                Delete
            </button>
            @endhasanyrole
        </div>
    </div>

    <div class="overflow-x-auto">
        <div class="mb-4 text-white">
            {{ $tasks->links() }}
        </div>
        <table class="min-w-full border border-gray-200 table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border min-w-[180px]">#</th>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border max-w-[180px]">Type</th>
                    <th class="px-4 py-2 border max-w-[180px]">Owner</th>
                    {{-- <th class="px-4 py-2 border">Category</th> --}}
                    <th class="px-4 py-2 border min-w-[180px]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center">{{ $task->task_code ?? "-" }}</td>
                    <td class="px-4 py-2 border text-center flex justify-between">
                        <div>
                            <a wire:click="linkClick({{ $task->id }})" class="no-underline hover:underline cursor-pointer {{ $task->status === 'completed' ? 'text-gray-500' : 'text-blue-600' }}">
                                {{ $task->title }}
                            </a>
                        </div>
                        <div>
                            <button wire:click="copy('{{ $task->title }}')" class=" opacity-50">
                                <img src="{{ asset('icons/copy.svg') }}" alt="Copy" class="w-4 h-4" />
                            </button>
                        </div>
                    </td>
                    <td class="px-4 py-1 border text-center text-sm">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full uppercase
                                @if (strtolower($task->status) === 'core') text-green-500 bg-green-100
                                @elseif(strtolower($task->status) === 'bug') text-rose-500 bg-rose-100
                                @elseif(strtolower($task->status) === 'completed') text-gray-700 bg-gray-100 opacity-60
                                @elseif(strtolower($task->status) === 'ui') text-purple-700 bg-purple-100
                                @else text-blue-600 bg-blue-100 @endif">
                            {{ $task->status ?? '—' }}
                        </span>
                    </td>
                    <td class="text-center border text-sm">
                        <div class="items-center">
                            @if($task->assigned_to === auth()->id())
                            <span class="text-xs text-green-600 font-semibold">You</span>
                            @else
                            <span class="text-xs text-gray-700">
                                {{ $task->assignee->name ?? '-' }}
                            </span>
                            @endif
                        </div>
                    </td>
                    {{-- <td
                            class="px-4 py-1 border text-center text-sm {{ $task->status === 'completed' ? 'text-gray-500' : '' }}">
                    {{ $task->category ?? '—' }}
                    </td> --}}
                    <td class="px-4 py-1 border text-center text-sm">
                        @if ($task->status !== 'completed')
                        <button wire:confirm="Are you sure you want to complete this post?" wire:click="markAsComplete({{ $task->id }})" class="px-3 py-1 text-sm font-medium text-gray-500 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                            <span wire:loading wire:target='markAsComplete({{ $task->id }})'>Processing..</span>
                            <span wire:loading.remove wire:target='markAsComplete({{ $task->id }})'>Mark as
                                Complete</span>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">No tasks found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Modal -->
    {{-- @if ($showModal) --}}
    <div wire:show="showModal">
        <div x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
                <button class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl font-bold" wire:click="handleCancle">&times;</button>

                <h2 class="text-lg font-semibold mb-4">Add New Task</h2>

                <form wire:submit.prevent="save" class="space-y-4 text-sm">
                    <div>
                        <label class="block text-sm font-medium mb-1">Title</label>
                        <textarea wire:model.defer="title" rows="6" class="w-full border rounded px-3 py-2"></textarea>
                        @error('title')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror

                    <div>
                        <label class="block text-sm font-medium mb-1">Assign To</label>
                        <select wire:model="assigned_to" class="w-full border border-gray-300 rounded px-3 py-2 text-gray-800">
                            @foreach($userAssignToThisProject as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                                @if($user->id === auth()->id()) (Me) @endif
                            </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    @if($modaltype === "view")
                    @if(count($existingFiles))
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold mb-2">Attached Files</h4>

                        <ul class="space-y-2">
                            @foreach($existingFiles as $file)
                            <li class="flex items-center justify-between bg-gray-100 p-2 rounded">
                                <div class="text-sm">
                                    📎 {{ $file->file_name }}
                                    <span class="text-xs text-gray-500">
                                        ({{ number_format($file->file_size / 1024, 1) }} KB)
                                    </span>
                                </div>

                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="text-blue-600 text-xs hover:underline">
                                    View
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @endif


                    @if($modaltype === "add")
                    <div>
                        @if ($photo)
                        <img class="h-20 w-20" src="{{ $photo->temporaryUrl() }}">
                        @endif
                        <label class="block text-sm font-medium mb-1">Upload File</label>

                        <input type="file" wire:model="photo" class="w-full border rounded px-3 py-2" />

                        <div wire:loading wire:target="photo" class="text-xs text-gray-500">
                            Uploading...
                        </div>

                        @error('photo')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif



                    <div class="flex justify-between">
                        <div class="w-full mr-2">
                            <select wire:model="status" class="w-full mr-2 border border-gray-300 rounded px-3 py-2 text-gray-800">
                                <option value="">Select priority </option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>

                        <div class="w-1/2 flex justify-end">
                            <button type="button" wire:click="handleCancle" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel
                            </button>

                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                                <span wire:loading wire:target="save">Saving...</span>
                                <span wire:loading.remove wire:target="save">Save</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('livewire.components.toast')

    @script
    <script>
        $js('copy', (data) => {
            const textToCopy = data;
            navigator.clipboard.writeText(textToCopy)
                .then(() => {})
                .catch(err => {
                    console.error('Failed to copy text: ', err);
                    alert('Failed to copy text.');
                });
        });

    </script>
    @endscript
</div>

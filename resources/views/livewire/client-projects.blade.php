<div class="p-6">
    <div class=" flex flex-row gap-5 justify-between">
        <h1 class="text-2xl font-bold mb-4">Learning Portal</h1>
        <button wire:click="$set('showModal', true)" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded">
            + New Project
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @if ($projects->count())
            @foreach ($projects as $project)
                <a href="{{ route('learning.project', $project->id) }}"
                    class="group block rounded-xl border border-gray-200 bg-white p-6 shadow-sm
                      hover:shadow-lg hover:border-blue-500 transition-all duration-200">

                    <!-- Header -->
                    <div class="flex items-start justify-between mb-3">
                        <h2 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600">
                            {{ $project->name }}
                            <span
                                class=" rounded-full text-white bg-rose-500 px-2 ml-auto">{{ $project->new_learnings_count }}</span>
                        </h2>

                        <!-- Arrow icon -->
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                        {{ $project->description ?? 'No description provided.' }}
                    </p>

                    <!-- Footer -->
                    <div class="mt-4 flex items-center text-xs text-gray-500">
                        <span class="px-2 py-1 bg-gray-100 rounded-full">
                            Project
                        </span>
                    </div>
                </a>
            @endforeach
        @else
            <div class="col-span-full text-center text-gray-500 py-12">
                No projects found.
            </div>
        @endif
    </div>

    @if ($showModal)
        <div class="fixed inset-0 px-20 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-md rounded-lg p-6">
                <h2 class="text-lg font-bold mb-4">Create Project</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Project Name</label>
                        <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Description</label>
                        <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-6 gap-2">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 border rounded">
                        Cancel
                    </button>

                    <button wire:click="createProject" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Create
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<div>
    <div class="max-w-xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-5">Add New Project</h1>

        <form wire:submit.prevent="saveProject" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" wire:model="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Save Project
                </button>
            </div>
        </form>
    </div>

    @include('livewire.components.toast')
</div>

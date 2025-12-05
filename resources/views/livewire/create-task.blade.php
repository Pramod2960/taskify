<div class="px-10 mx-auto p-6 bg-white rounded mt-2 h-full text-sm">
    @if (session()->has('message'))
        <div class="mb-4 text-green-600">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="text-sm">
        <div class="mb-4" wire:dirty.class="bg-yellow-100" wire:target="title">
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" wire:model="title" class="w-full border rounded px-3 py-2 text-sm">
            @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1" wire:dirty.class="bg-yellow-100"
                wire:target="requirment">Requirnment</label>
            <div class="h-20 mb-10" wire:ignore>
                <input id="x-1" type="hidden" wire:model='requirment' name="requirment"
                    value="{{ old('content', $content ?? '') }}">
                <trix-editor input="x-1" class="h-20 overflow-scroll"
                    x-on:trix-change="$wire.requirment = $event.target.value"></trix-editor>
            </div>
            @error('requirment')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Body</label>
            <div class="h-20 mb-10" wire:ignore>
                <input id="x" type="hidden" wire:model='body ' name="body"
                    value="{{ old('content', $content ?? '') }}">
                <trix-editor input="x" class="h-20 overflow-scroll"
                    x-on:trix-change="$wire.body = $event.target.value"></trix-editor>
            </div>
            @error('body')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-4 gap-3">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Project</label>
                <select wire:model="project_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- Select Project --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Assigner</label>
                <select wire:model="assigner_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- Select Assigner --</option>
                    @foreach ($assigners as $assigner)
                        <option value="{{ $assigner->id }}">{{ $assigner->name }}</option>
                    @endforeach
                </select>
                @error('assigner_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Start Date</label>
                <input type="date" wire:model="start_date" class="w-full border rounded px-3 py-2 text-sm">
                @error('start_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Completion Date</label>
                <input type="date" wire:model="completion_date" class="w-full border rounded px-3 py-2 text-sm">
                @error('completion_date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            <span wire:loading>Saving...</span>
            <span wire:loading.remove>Save</span>
        </button>

    </form>

</div>

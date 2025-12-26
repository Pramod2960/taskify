<div class="mx-10 p-6 bg-white rounded shadow">

    <h1 class="text-3xl font-bold mb-8">Form Builder</h1>

    <div class="space-y-10">

        {{-- ===================================================== --}}
        {{-- 1. CREATE PROJECT / FORM --}}
        {{-- ===================================================== --}}
        {{-- <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Create Project</h2>

            <div class="flex gap-4">
                <input type="text" wire:model="form_name" placeholder="Enter project name"
                    class="border px-3 py-2 w-80 rounded">
                <button wire:click="createForm"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Project
                </button>
            </div>

            @if (session()->has('message'))
                <p class="mt-3 text-green-600 font-semibold">{{ session('message') }}</p>
            @endif
        </div> --}}


        {{-- ===================================================== --}}
        {{-- 2. ADD SECTION --}}
        {{-- ===================================================== --}}
        {{-- @if ($form_id)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Add Section</h2>

                <div class="flex gap-4">
                    <input type="text" wire:model="section_name" placeholder="Enter section name"
                        class="border px-3 py-2 w-80 rounded">

                    <button wire:click="addSection"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Add Section
                    </button>
                </div>
            </div>
        @endif --}}


        {{-- ===================================================== --}}
        {{-- 3. ADD FIELD --}}
        {{-- ===================================================== --}}
        {{-- @if ($form_id && $form->sections->count()) --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Add Field</h2>

                {{-- Select Section --}}
                {{-- <div class="mb-6 w-80">
                    <label class="font-semibold">Choose Section</label>
                    <select wire:model="section_id" class="border px-3 py-2 w-full rounded">
                        <option value="">Select Section</option>

                        @foreach ($form->sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- @if ($section_id) --}}

                    {{-- FIELD INPUT FORM --}}
                    <form wire:submit.prevent="addField"
                        class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Field Name --}}

                         <div>
                            <label class="font-medium mb-1 block">Section Name</label>
                            <input type="text" wire:model="section_name" class="w-full border px-3 py-2 rounded">
                        </div>


                        <div>
                            <label class="font-medium mb-1 block">Field Name</label>
                            <input type="text" wire:model="field_name" class="w-full border px-3 py-2 rounded">
                        </div>

                        {{-- Field ID --}}
                        <div>
                            <label class="font-medium mb-1 block">Field Internal ID</label>
                            <input type="text" wire:model="field_id" class="w-full border px-3 py-2 rounded">
                        </div>

                        {{-- Tooltip --}}
                        <div>
                            <label class="font-medium mb-1 block">Tooltip</label>
                            <input type="text" wire:model="tooltip" class="w-full border px-3 py-2 rounded">
                        </div>

                        {{-- Data Type --}}
                        <div>
                            <label class="font-medium mb-1 block">Data Type</label>
                            <select wire:model.live="data_type" class="w-full border px-3 py-2 rounded">
                                <option value="">Choose...</option>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                            </select>
                        </div>

                        {{-- Mandatory --}}
                        <div>
                            <label class="font-medium mb-1 block">Required?</label>
                            <select wire:model="mandatory" class="w-full border px-3 py-2 rounded">
                                <option value="">Choose...</option>
                                <option value="1">Mandatory</option>
                                <option value="0">Optional</option>
                            </select>
                        </div>

                        {{-- Max Length --}}
                        @if ($data_type === 'text' || $data_type === 'textarea')
                            <div>
                                <label class="font-medium mb-1 block">Max Length</label>
                                <input type="number" wire:model="max_length" class="w-full border px-3 py-2 rounded">
                            </div>
                        @endif

                        {{-- Rows --}}
                        @if ($data_type === 'textarea')
                            <div>
                                <label class="font-medium mb-1 block">Rows</label>
                                <input type="number" wire:model="rows" class="w-full border px-3 py-2 rounded">
                            </div>
                        @endif

                        {{-- Visibility --}}
                        <div>
                            <label class="font-medium mb-1 block">Visibility Type</label>
                            <select wire:model.live="visibility_type" class="w-full border px-3 py-2 rounded">
                                <option value="always">Always</option>
                                <option value="conditional">Conditional</option>
                            </select>
                        </div>

                        {{-- Conditional logic --}}
                        @if ($visibility_type === 'conditional')
                            <div>
                                <label class="font-medium mb-1 block">Trigger Field ID</label>
                                <input type="text" wire:model="visibility_field"
                                    class="w-full border px-3 py-2 rounded">
                            </div>
                            <div>
                                <label class="font-medium mb-1 block">Trigger Value</label>
                                <input type="text" wire:model="visibility_value"
                                    class="w-full border px-3 py-2 rounded">
                            </div>
                        @endif

                        {{-- Sync Field --}}
                        <div>
                            <label class="font-medium mb-1 block">Sync Field (Salesforce, etc.)</label>
                            <input type="text" wire:model="sync_field" class="w-full border px-3 py-2 rounded">
                        </div>

                        <div class="col-span-3 mt-4">
                            <button class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                                Save Field
                            </button>
                        </div>
                    </form>

                {{-- @endif --}}

            </div>
        {{-- @endif --}}


        {{-- ===================================================== --}}
        {{-- 4. SHOW FORM STRUCTURE --}}
        {{-- ===================================================== --}}
        @if ($form_id)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold mb-6">Project Structure</h2>

                @forelse ($form->sections as $section)
                    <div class="mb-8 border rounded p-4 bg-gray-50">

                        <h3 class="text-lg font-semibold mb-3 text-blue-700">
                            {{ $section->section_name }}
                        </h3>

                        @if ($section->fields->count())
                            <ul class="space-y-1 ml-4">
                                @foreach ($section->fields as $field)
                                    <li class="p-2 border rounded bg-white flex justify-between">
                                        <div>
                                            <strong>{{ $field->field_name }}</strong>
                                            <span class="text-gray-600">({{ $field->data_type }})</span>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $field->field_id }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-600 ml-4">No fields added.</p>
                        @endif

                    </div>
                @empty
                    <p>No sections added yet.</p>
                @endforelse

            </div>
        @endif

    </div>
</div>

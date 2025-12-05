   <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">

       <h2 class="text-2xl font-bold mb-4">Create Form Field</h2>
       <form wire:submit.prevent="save" class="text-sm">

           {{-- Section Name --}}
           <div class="mb-4"> <label class="block font-medium mb-1">Section Name</label> <input type="text"
                   wire:model="section_name" class="w-full border rounded px-3 py-2" placeholder="Enter section name">
               @error('section_name')
                   <span class="text-red-600 text-sm">{{ $message }}</span>
               @enderror
           </div>


           {{-- Field Display Name --}}
           <div class="mb-4"> <label class="block font-medium mb-1">Field Name
                   (Label)</label> <input type="text" wire:model="field_name" class="w-full border rounded px-3 py-2"
                   placeholder="Enter field name shown on web">
               @error('field_name')
                   <span class="text-red-600 text-sm">{{ $message }}</span>
               @enderror
           </div>


           {{-- Tooltip Name --}}
           <div class="mb-4">
               <label class="block font-medium mb-1">ToolTip </label>
               <input type="text" wire:model="tooltip" class="w-full border rounded px-3 py-2"
                   placeholder="Enter tooltip here">
               @error('tooltip')
                   <span class="text-red-600 text-sm">{{ $message }}</span>
               @enderror
           </div>


           {{-- Field ID --}} <div class="mb-4"> <label class="block font-medium mb-1">Field ID (Internal /
                   Key)</label> <input type="text" wire:model="field_id" class="w-full border rounded px-3 py-2"
                   placeholder="Enter field identifier (e.g., first_name)"> @error('field_id')
                   <span class="text-red-600 text-sm">{{ $message }}</span>
               @enderror
           </div>
           

           {{-- Data Type --}}
           <div class="mb-4">
               <label class="block font-medium mb-1">Data Type</label>
               <select wire:model.live="data_type" class="w-full border rounded px-3 py-2">
                   <option value="">Select type</option>
                   <option value="text">Text</option>
                   <option value="textarea">Textarea</option>
                   <option value="number" disabled>Number</option>
                   <option value="email" disabled>Email</option>
                   <option value="date" disabled>Date</option>
                   <option value="select" disabled>Select (Dropdown)</option>
                   <option value="checkbox" disabled>Checkbox</option>
               </select>
               @error('data_type')
                   <span class="text-red-600 text-sm">{{ $message }}</span>
               @enderror
               @if ($data_type === 'text')
                   <div class="mt-2 mb-4 bg-rose-200">
                       <label class="block font-medium mb-1">Max Length</label>
                       <input type="number" wire:model="max_length" class="w-full border rounded px-3 py-2"
                           placeholder="Enter maximum characters">
                       @error('max_length')
                           <span class="text-red-600 text-sm">{{ $message }}</span>
                       @enderror
                   </div>
               @endif
               @if ($data_type === 'textarea')
                   <div class="mt-2">
                       <div class="mb-4 bg-rose-200">
                           <label class="block font-medium mb-1">Max Length</label>
                           <input type="number" wire:model="max_length" class="w-full border rounded px-3 py-2"
                               placeholder="Enter maximum characters">
                           @error('max_length')
                               <span class="text-red-600 text-sm">{{ $message }}</span>
                           @enderror
                       </div>
                       <div class="mb-4  bg-rose-200">
                           <label class="block font-medium mb-1">Rows</label>
                           <input type="number" wire:model="rows" class="w-full border rounded px-3 py-2"
                               placeholder="Enter number of rows">
                           @error('rows')
                               <span class="text-red-600 text-sm">{{ $message }}</span>
                           @enderror
                       </div>
                   </div>
               @endif
           </div>

           {{-- Mandatory --}}
           <div class="mb-4"> <label class="block font-medium mb-1">Mandatory</label>
               <select wire:model="mandatory" class="w-full border rounded px-3 py-2">
                   <option value="">Choose...</option>
                   <option value="1">Mandatory</option>
                   <option value="0">Optional</option>
               </select> @error('mandatory')
                   <span class="text-red-600 text-sm">{{ $message }}</span>
               @enderror
           </div>
           

           {{-- Submit --}}
           <div class="flex flex-row justify-between">
               <div class="flex">
                   <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" type="submit"> Save
                       Field
                   </button>
               </div>
               <div class="flex">
                   @if (session()->has('message'))
                       <div class=" p-2 text-green-700 bg-green-100 rounded">
                           {{ session('message') }}
                       </div>
                   @endif
               </div>
           </div>
       </form>
   </div>

<div class="w-full px-10 h-screen p-6 bg-white rounded text-sm mt-2">
    <div class="flex justify-between items-center mb-2">
        <div>
            <h2 class="text-xl font-semibold ">All Tasks</h2>
        </div>
        <div class=" flex gap-2">
            <div>
                <input wire:model.live.debounce.300ms="search" placeholder="Search by Title "
                    class=" rounded-lg p-1 px-2 text-sm" />
            </div>
            <div>
                <label for="filterDate" class="mr-2 font-medium">Filter by date:</label>
                <input type="date" id="filterDate" name="filterDate" wire:model.live='filter_date'
                    class="border rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    onchange="filterTasksByDate(this.value)">
            </div>
            <div>
                <button wire:click="clearFilter" class="bg-slate-300 text-black px-4 py-1 rounded">
                    Clear Filter
                </button>
                {{-- <button wire:click="$refresh" class="bg-slate-300 text-black px-4 py-1 rounded">
                    <span wire:loading>Refreshing...</span>
                    <span wire:loading.remove>Refresh</span>
                </button> --}}
            </div>
        </div>
    </div>


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Project</th>
                    <th class="px-4 py-2 border">Assigner</th>
                    <th class="px-4 py-2 border">Start </th>
                    <th class="px-4 py-2 border">Completion </th>
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
            inline-block px-2 py-1 text-xs font-semibold  rounded-full uppercase
            @if (strtolower($task->status) === 'new') text-yellow-500  bg-yellow-100 
            @elseif(strtolower($task->status) === 'completed') text-green-700 bg-green-100 opacity-60
            @elseif(strtolower($task->status) === 'overdue') text-red-700
            @else text-blue-600 bg-blue-100 @endif
        ">
                                {{ $task->status ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-1 border text-center text-sm">
                            <span
                                class=" p-2 inline-block px-2 py-1 text-xs font-semibold  rounded-full uppercase
        @php $name = strtolower($task->project->name ?? ''); @endphp
        @if ($name === 'migrator') text-purple-400
        @elseif ($name === 'seco')
            text-green-700
        @elseif ($name === 'cxp_crm')
            text-red-700
        @else
            text-blue-600 bg-blue-100 @endif
    ">
                                {{ $task->project->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">{{ $task->assigner->name ?? '—' }}</td>
                        <td class="px-4 py-2 border"> {{ \Carbon\Carbon::parse($task->start_date)->format('d M') }}
                        </td>
                        <td class="px-4 py-2 border">
                            {{ $task->completion_date ? \Carbon\Carbon::parse($task->completion_date)->format('d M') : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

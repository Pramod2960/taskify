<div class="w-full px-10 h-screen p-6 bg-white rounded text-sm mt-2 mb-10">
    <div class="flex justify-between items-center mb-2">
        <div>
            <h2 class="text-xl font-semibold ">All Tasks</h2>
        </div>
        <div class=" flex gap-2 ">
            <div>
                <input wire:model.live.debounce.300ms="search" placeholder="Search by Title "
                    class=" rounded-lg p-1 px-2 text-sm" />
            </div>
            <div>
                <label for="filterDate" class="mr-2 font-medium">Filter Projects:</label>
                <select class="border rounded px-5 py-1  focus:outline-none focus:ring-2 focus:ring-blue-400"
                    wire:model.live="filter_project">
                    <option value="">Projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
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
        <div class="mb-4 text-white">
            {{ $tasks->links() }}
        </div>
        <table class="min-w-full border border-gray-200 table-auto mb-10">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Title</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Project</th>
                    <th class="px-4 py-2 border">Assigner</th>
                    <th class="px-4 py-2 border min-w-20">Start </th>
                    <th class="px-4 py-2 border "><pre>   Due   </pre></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $index => $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('task.show', $task->id) }}" wire:navigate
                                class="
       @if ($task->status === 'completed') text-gray-500 hover:underline
       @elseif($task->status === 'watching')
           text-purple-600 hover:underline
       @else
           text-blue-600 hover:underline @endif
   ">
                                {{ $task->title }}
                            </a>

                        </td>
                        <td class="px-4 py-1 border text-center text-sm">
                            <span
                                class="
        inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full uppercase
        @if (strtolower($task->status) === 'new') text-rose-500 bg-rose-100
        @elseif(strtolower($task->status) === 'watching') text-purple-700 bg-purple-100 opacity-70
        @elseif(strtolower($task->status) === 'completed') text-gray-700 bg-gray-100 opacity-60
        @elseif(strtolower($task->status) === 'overdue') text-red-700
        @else text-blue-600 bg-blue-100 @endif
    ">
                                @if (strtolower($task->status) === 'watching')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                @endif
                                {{ $task->status ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-1 border text-center text-sm">
                            <span
                                class=" p-2 inline-block px-2 py-1 text-xs font-semibold  rounded-full uppercase
        @php $name = strtolower($task->project->name ?? ''); @endphp
        @if ($task->status === 'completed') text-gray-500
        @elseif ($name === 'migrator') text-rose-300
        @elseif ($name === 'seco') text-green-700
        @elseif ($name === 'cxp_crm')text-red-700
        @else text-blue-500 @endif
    ">
                                {{ $task->project->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border {{ $task->status === 'completed' ? 'text-gray-500' : '' }}">
                            {{ $task->assigner->name ?? '—' }}</td>
                        <td class="px-4 py-2 border"> {{ \Carbon\Carbon::parse($task->start_date)->format('d M') }}
                        </td>
                        <td class="px-4 py-2 border">
                            @php
                                $start = \Carbon\Carbon::parse($task->start_date);
                                $today = \Carbon\Carbon::today();
                                $diffDays = $start->diffInDays($today);
                            @endphp
                            @if (in_array($task->status, ['pending', 'New']))
                                <span class="text-sm text-rose-600 ml-1">
                                 <span class="font-semibold">{{ $diffDays }}</span> days
                                </span>
                            @endif
                            {{-- {{ $task->completion_date ? \Carbon\Carbon::parse($task->completion_date)->format('d M') : '-' }} --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

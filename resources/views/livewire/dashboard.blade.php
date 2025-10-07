<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Completed Tasks Card -->
        <div class="bg-green-400 text-white rounded-lg shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold">{{ $completed }}</div>
            <div class="mt-2 text-lg font-medium">Completed Tasks</div>
        </div>

        <!-- Watching Tasks Card -->
        <div class="bg-blue-400 text-white rounded-lg shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold">{{ $watching }}</div>
            <div class="mt-2 text-lg font-medium">Watching Tasks</div>
        </div>

        <!-- New Tasks Card -->
        <div class="bg-yellow-400 text-white rounded-lg shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold">{{ $newCount }}</div>
            <div class="mt-2 text-lg font-medium">New Tasks</div>
        </div>
    </div>
</div>

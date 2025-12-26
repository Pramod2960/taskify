<div class="space-y-8 px-10 mt-10">

    <div class="flex flex-wrap gap-4">
        <button wire:click="generateHtml" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate
            HTML</button>
        <button wire:click="generateJS" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate
            JS</button>
        <button wire:click="generateController"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate Controller</button>
        <button wire:click="generateMigration"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Generate Migration</button>
    </div>

    {{-- HTML Preview --}}
    @if ($generatedHtml)
        <div class="mt-6">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-xl font-semibold text-black">Generated HTML Preview</h4>
                <button wire:click="copy('{{ $generatedHtml }}')"
                    class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800">Copy</button>
            </div>
            <div class="p-6 bg-black text-white rounded-lg shadow-sm overflow-x-auto">
                <pre class="prose prose-sm max-w-none">{{ $generatedHtml }}</pre>
            </div>
        </div>
    @endif

    {{-- JS Preview --}}
    @if ($generatedJS)
        <div class="mt-6">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-xl font-semibold text-black">Generated JS Preview</h4>
                <button wire:click="copy('{{ $generatedJS }}')"
                    class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800">Copy</button>
            </div>
            <div class="p-6 bg-black text-white rounded-lg shadow-sm overflow-x-auto">
                <pre class="prose prose-sm max-w-none">{{ $generatedJS }}</pre>
            </div>
        </div>
    @endif

    {{-- Controller Preview --}}
    @if ($generatedController)
        <div class="mt-6">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-xl font-semibold text-black">Generated Controller Preview</h4>
                <button wire:click="copy('{{ $generatedController }}')"
                    class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800">Copy</button>
            </div>
            <div class="p-6 bg-black text-white rounded-lg shadow-sm overflow-x-auto">
                <pre class="prose prose-sm max-w-none">{{ $generatedController }}</pre>
            </div>
        </div>
    @endif

    {{-- Migration Preview --}}
    @if ($generatedMigration)
        <div class="mt-6">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-xl font-semibold text-black">Generated Migration Preview</h4>
                <button wire:click="copy('{{ $generatedMigration }}')"
                    class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800">Copy</button>
            </div>
            <div class="p-6 bg-black text-white rounded-lg shadow-sm overflow-x-auto">
                <pre class="prose prose-sm max-w-none">{{ $generatedMigration }}</pre>
            </div>
        </div>
    @endif

</div>




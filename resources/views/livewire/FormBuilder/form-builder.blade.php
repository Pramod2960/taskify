<div>
    @include('livewire.FormBuilder.1-form')

    <div class="px-10 mb-8">
        <button wire:click="generateHtml" class="btn btn-primary">Generate</button>
        <hr>
        @if ($generatedHtml)
            <div class="mt-8 text-black">
                <h4 class="text-xl font-semibold mb-3">
                    Generated Form Preview
                </h4>
                <div class="p-6 bg-black border text-white rounded-lg shadow-sm">
                    <div class="prose prose-sm max-w-none">
                        {{ $generatedHtml }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

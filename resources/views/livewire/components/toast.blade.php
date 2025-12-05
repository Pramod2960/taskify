<div class="fixed bottom-10 right-5 z-50 w-80">
    @if ($showToast)
    <div id="toast"
         class="{{ $toastType == 'success' ? 'bg-green-500' : 'bg-rose-500' }} 
                text-white px-4 py-2 rounded shadow-lg flex items-center justify-between items-center gap-2 transition duration-300" wire:transition>

        <div class="flex items-center gap-2">
            @if ($toastType == 'success')
                <img src="{{ asset('icons/badge-check.svg') }}" alt="Success" class="w-4 h-4 fill-white">
            @endif
            {{ $toastMessage }}
        </div>

        <button wire:click="$set('showToast', false)" class="text-white font-bold ml-4 hover:text-gray-200">&times;</button>
    </div>
    @endif
</div>

@script
    <script>
        $js('hideToast', () => {
            const timeout = 4000;
            console.log("hide toast started");
            setTimeout(() => {
                $wire.set('showToast', false);
            }, timeout);
        });
    </script>
@endscript

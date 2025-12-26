<div>
    @include('livewire.FormBuilder.1-form')

    @include('livewire.FormBuilder.2-generate-section')

    @script
        <script>
            console.log('je');
            window.addEventListener('copy', event => {
                const textToCopy = event.detail.text;
                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        alert('Text copied to clipboard!');
                    })
                    .catch(err => {
                        console.error('Failed to copy text: ', err);
                        alert('Failed to copy text.');
                    });
            });
        </script>
    @endscript
</div>

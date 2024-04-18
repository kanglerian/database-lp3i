@push('scripts')
    <script>
        const copyRecord = (number) => {
            const textarea = document.createElement("textarea");
            textarea.value = number;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert('Nomor rekening sudah disalin!');
        }
    </script>
@endpush

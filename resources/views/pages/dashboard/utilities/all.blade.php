@push('utilities')
    <script>
        let identityVal = document.getElementById('identity_val').value;
        let roleVal = document.getElementById('role_val').value;
    </script>
    <script>
        const copyIdentity = (identity) => {
            const textarea = document.createElement("textarea");
            textarea.value = identity;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert('ID sudah disalin!');
        }
    </script>
@endpush

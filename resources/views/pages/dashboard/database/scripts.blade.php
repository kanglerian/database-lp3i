@push('scripts')
    @if (Auth::user()->role == 'P')
        <script>
            const changeTrigger = () => {
                changeFilterDatabase();
                changeFilterTarget();
            }
        </script>
    @endif
    @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
        <script>
            const changeTrigger = () => {
                changeFilterDatabase();
                changeFilterDataRegisterProgram();
                changeFilterRekapitulasi();
            }
        </script>
    @endif
@endpush

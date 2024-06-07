@push('scripts')
    @if (Auth::user()->role == 'P')
        <script>
            const changeTrigger = () => {
                changeFilterDatabase();
                changeFilterTarget();
                changeFilterMapRegisterSchoolYear();
            }
        </script>
    @endif
    @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
        <script>
            const changeTrigger = () => {
                changeFilterDatabase();
                changeFilterDataRegisterProgram();
                changeFilterRekapitulasi();
                changeDataSales();
                changeFilterMapRegisterSchoolYear();
            }
        </script>
    @endif
@endpush

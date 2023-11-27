@if (Auth::user()->role == 'P')
<script>
    const getRegistrations = async () => {
        await axios.get(apiTargets)
            .then((res) => {
                let dataTargets = res.data.targets;
                let targets = 0;
                let registers = res.data.registrations.length;
                dataTargets.forEach(data => {
                    targets += parseInt(data.total);
                });
                document.getElementById('register_count').innerText = registers;
                document.getElementById('target_count').innerText = targets;
                document.getElementById('result_count').innerText = targets - registers;
                if (targets - registers <= 0) {
                    document.getElementById('animate').classList.remove('hidden');
                    document.getElementById('container-animate').classList.remove('bg-red-500');
                    document.getElementById('container-animate').classList.add('bg-yellow-500');
                    document.getElementById('result_count').classList.remove('bg-red-600');
                    document.getElementById('result_count').classList.add('bg-yellow-600');
                } else {
                    document.getElementById('animate').classList.add('hidden');
                    document.getElementById('container-animate').classList.remove('bg-yellow-500');
                    document.getElementById('container-animate').classList.add('bg-red-500');
                    document.getElementById('result_count').classList.add('bg-red-600');
                    document.getElementById('result_count').classList.remove('bg-yellow-600');
                }
            })
            .catch((err) => {
                console.log(err);
            });
    }
    getRegistrations();
</script>
@endif

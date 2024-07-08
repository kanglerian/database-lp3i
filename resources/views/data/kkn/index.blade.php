@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-guest-layout>
    <section class="flex items-center justify-center h-screen bg-gray-100">
        <div class="max-w-xl w-full mx-auto space-y-8">
            <div class="w-full flex items-center justify-center">
                <a href="{{ route('welcome') }}" class="flex items-center gap-5">
                    <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="w-48">
                    <img src="{{ asset('logo/logo-kampusglobalmandiri.png') }}" alt="Kampus Global Mandiri"
                        class="w-40">
                </a>
            </div>
            <form class="max-w-5xl w-full mx-auto space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your
                            email</label>
                        <input type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="name@flowbite.com" required />
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your
                            email</label>
                        <input type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="name@flowbite.com" required />
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Register
                        new account</button>
                </div>
            </form>
        </div>
    </section>
</x-guest-layout>
<script src="{{ asset('js/indonesia.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2({
            tags: true,
        });
    });

    const filterProgram = async () => {
        let programType = document.getElementById('programtype_id').value;
        await axios.get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs')
            .then((res) => {
                let programs = res.data;
                var results;
                let bucket = '';
                switch (programType) {
                    case "1":
                        results = programs.filter(program => program.regular === "1");
                        break;
                    case "2":
                        results = programs.filter(program => program.employee === "1");
                        break;
                    default:
                        document.getElementById('program').innerHTML =
                            `<option value="0">Pilih Program Studi</option>`;
                        document.getElementById('program').disabled = true;
                        break
                }
                if (programType != 0 && programType != 3) {
                    results.map((result) => {
                        console.log(result);
                        let option = '';
                        result.interest.map((inter, index) => {
                            option +=
                                `<option value="${result.level} ${result.title}">${inter.name}</option>`;
                        })
                        bucket += `
                    <optgroup label="${result.level} ${result.title} (${result.campus})">
                        ${option}
                    </optgroup>`;
                    });
                    document.getElementById('program').innerHTML = bucket;
                    document.getElementById('program').disabled = false;
                }
            })
            .catch((err) => {
                console.log(err.message);
            });

    }

    const seePassword = () => {
        let passwordElement = document.getElementById('password');
        let seeElement = document.getElementById('see-password');
        let attribute = passwordElement.getAttribute('type');
        if (attribute === 'text') {
            passwordElement.setAttribute('type', 'password');
            seeElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
        } else {
            passwordElement.setAttribute('type', 'text');
            seeElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        }
    }

    const seePasswordConfirmation = () => {
        let passwordElement = document.getElementById('password_confirmation');
        let seeElement = document.getElementById('see-password-confirmation');
        let attribute = passwordElement.getAttribute('type');
        if (attribute === 'text') {
            passwordElement.setAttribute('type', 'password');
            seeElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
        } else {
            passwordElement.setAttribute('type', 'text');
            seeElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        }
    }

    const getYearPMB = () => {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
        document.getElementById('pmb').value = startYear;
    }
    getYearPMB();
    let phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let phone = phoneInput.value;

        if (phone.startsWith("62")) {
            if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                phoneInput.value = '62';
            } else {
                phoneInput.value = phone;
            }
        } else if (phone.startsWith("0")) {
            phoneInput.value = '62' + phone.substring(1);
        } else {
            phoneInput.value = '62';
        }
    });
</script>

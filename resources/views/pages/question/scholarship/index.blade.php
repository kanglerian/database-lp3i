<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('question.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-file-lines mr-2"></i>
                            E-Assessment
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">SBPMB Online</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-scroll"></i>
                    <h2 id="count_questions"></h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="flex flex-wrap justify-between items-center gap-4 md:gap-0 px-2">
                <div class="flex items-center gap-3">
                    <a href="{{ route('scholarship.question') }}" class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-lg text-white">
                        <i class="fa-solid fa-scroll mr-1"></i> Bank Soal
                    </a>
                </div>
            </div>

            <div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias ea accusamus, voluptate sapiente,
                    minus ducimus quidem harum maiores adipisci sequi dignissimos! Id exercitationem sunt minus.
                    Sapiente perferendis nihil obcaecati harum vitae laborum, animi ullam. Provident placeat nobis
                    exercitationem voluptatum cupiditate quia laborum, quae amet, eaque odit assumenda recusandae
                    corporis quod? Cupiditate alias consequatur, possimus atque ratione recusandae harum veniam quidem
                    magnam natus quasi quis nulla neque consequuntur voluptatum eius at vero cum sapiente officia
                    repellendus facilis reprehenderit. Velit numquam laudantium harum ducimus quasi quaerat autem fuga
                    voluptatibus. Ut reprehenderit sapiente et mollitia omnis nesciunt optio, accusamus enim doloribus
                    nulla delectus?</p>
            </div>
        </div>
    </div>
</x-app-layout>

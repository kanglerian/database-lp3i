<div class="flex flex-row items-end md:gap-3 flex-wrap md:flex-nowrap md:overflow-x-auto px-3">
    <div class="w-1/2 space-y-1 p-1 md:p-0">
        <label for="change_region" class="text-xs">Wilayah: </label>
        <select id="change_region" onchange="changeFilter()"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih</option>
            @foreach ($schools_by_region as $school)
                <option value="{{ $school->region }}">{{ $school->region }}</option>
            @endforeach
        </select>
    </div>
</div>

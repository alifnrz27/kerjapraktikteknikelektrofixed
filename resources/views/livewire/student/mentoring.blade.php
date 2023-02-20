<div>
    <div class="w-full p-4 mb-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
        <div class="w-full self-center px-4 flex justify-between">
            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">History Bimbingan</h1>
            @if($submissionStatus < 30)
            <form wire:submit.prevent="confirmAddMentoring" class="w-4/12">
                <button type="submit" class="text-base font-semibold text-white mb-3 bg-primary py-3 px-4 rounded-full hover:opacity-80 hover:shadow-lg transition duration-500 w-full">Ajukan</button>
            </form>
            @endif
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        @if(count($mentoring) == 0)
                        <div class="m-2 rounded-lg p-1 hover:opacity-50 transition duration-400">
                            <img src="/src/img/icons/undraw_no_data_re_kwbl.svg" class="mx-auto" width="200px" alt="">
                        </div>
                        @else
                        <table class="min-w-full">
                            <thead class="border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                No
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Waktu
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Keterangan
                                    </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($mentoring as $m)
                                <tr class="border-b">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration  }}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4">
                                    {{ $m->date }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $m->description }}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4">
                                        {{ $mentoringStatus[$m->mentoring_status_id - 1]->name }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

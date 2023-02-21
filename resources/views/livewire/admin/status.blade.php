<div>
    <div class="w-full p-4 mb-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
        <div x-data="{open:false}" class="w-full self-center px-4 flex justify-center">
            <h1 class="w-6/12 text-base font-semibold text-primary dark:text-white md:text-xl">Daftar yang belum diberi keterangan</h1>
            <button @click="open=true" class="text-base font-semibold text-white mb-3 bg-primary py-3 px-4 rounded-full hover:opacity-80 hover:shadow-lg transition duration-500 w-4/12">History</button>

            <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-screen bg-black/50 flex justify-center items-center">
                <section @click.outside="open = false" id="history-status" class="fixed w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto dark:bg-dark top-0 shadow-lg bg-primary" style="margin: auto; overflow:auto">
                    <div class="w-full p-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
                        <div class="w-full flex justify-between self-center px-4">
                            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">History</h1>
                            <button @click="open=false" class="text-base text-black">x</button>
                        </div>
                        
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        @if(count($statusHistory) == 0)
                                        <div class="m-2 rounded-lg p-1 hover:opacity-50 transition duration-400">
                                            <img src="{{asset('/src/img/icons/undraw_no_data_re_kwbl.svg')}}" class="mx-auto" width="200px" alt="">
                                        </div>
                                        @else
                                        <table class="min-w-full">
                                            <thead class="border-b">
                                            <tr>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                No
                                                </th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Nama
                                                </th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                Aksi
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($statusHistory as $s)
                                                <tr class="border-b">
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4">
                                                    {{ $s->user->name }}
                                                    </td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 flex">
                                                        @if($s->user->active_id == 1)    
                                                            <button type="button"  wire:click="acceptUpdateConfirm('{{ $s->user_id }}', {{ $s->id }})">
                                                                <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                                                                    <img src="{{asset('/src/img/icons/graduated.png')}}" width="25px" alt="">
                                                                </div>
                                                            </button>
                                                        @elseif($s->user->active_id == 0)
                                                            <button type="button" wire:click="declineUpdateConfirm('{{ $s->user_id }}', {{ $s->id }})">
                                                                <div class="m-2 rounded-lg bg-red-500 p-1 hover:opacity-50 transition duration-400">
                                                                    <img src="{{asset('/src/img/icons/stop.png')}}" width="25px" alt="">
                                                                </div>
                                                            </button>
                                                        @endif
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
                </section>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        @if(count($status) == 0)
                        <div class="m-2 rounded-lg p-1 hover:opacity-50 transition duration-400">
                            <img src="{{asset('/src/img/icons/undraw_no_data_re_kwbl.svg')}}" class="mx-auto" width="200px" alt="">
                        </div>
                        @else
                        <table class="min-w-full">
                            <thead class="border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                No
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Nama
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Aksi
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($status as $s)
                                <tr class="border-b">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4">
                                    {{ $s->user->name }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 flex">
                                        <button title="terima" type="button" wire:click="acceptConfirm('{{ $s->user_id }}', {{ $s->id }})">
                                            <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                                                <img src="{{asset('/src/img/icons/graduated.png')}}" width="25px" alt="">
                                            </div>
                                        </button>
                                        <button title="tolak" type="button" wire:click="declineConfirm('{{ $s->user_id }}', {{ $s->id }})">
                                            <div class="m-2 rounded-lg bg-red-500 p-1 hover:opacity-50 transition duration-400">
                                                <img src="{{asset('/src/img/icons/stop.png')}}" width="25px" alt="">
                                            </div>
                                        </button>
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

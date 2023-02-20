<div>
    <div class="w-full p-4 mb-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[2000px] overflow-auto">
        <div class="w-full self-center px-4 lg:w-1/2">
            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Daftar antri bimbingan</h1>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        @if(count($mentoringsQueue) == 0)
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
                                Nama
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Waktu
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Keterangan
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Aksi
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($mentoringsQueue as $q)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4">
                                        {{ $q->student->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $q->time }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $q->description }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 flex">
                                            <form title="selesai" wire:submit.prevent="confirmFinishMentoring({{ $q->id }})">
                                                @csrf
                                                <button type="submit">
                                                    <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                                                        <img src="/src/img/icons/check.png"width="25px" alt="">
                                                    </div>
                                                </button>
                                            </form>

                                            <div>
                                            <div class="w-full self-center px-4 flex justify-end"  x-data="{open: false}">
                                                <div x-data={open:false}>
                                                    <button title="update" @click="open=true">
                                                        <div class="m-2 rounded-lg  min-w-[150px] bg-primary p-3 hover:opacity-50 transition text-white duration-400">
                                                            <img src="/src/img/icons/edit.png"width="25px" alt="">
                                                        </div>
                                                    </button>
                                                    <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-full bg-black/50 flex justify-center items-center">
                                                            <section @click.outside="open = false" x-show="open" class="fixed lg:w-4/12 p-3 mb-5 mx-auto my-auto shadow-lg bg-blue-400 max-h-[700px]" style="margin: auto">
                                                                <div class="w-full p-4 bg-white rounded-lg max-h-[650px] overflow-hidden">
                                                                    <div class="w-full flex justify-between self-center px-4">
                                                                        <h1 class="text-base font-semibold text-blue-400 md:text-xl">Tambahkan Berkas Pengajuan</h1>
                                                                        <button @click="open=false" class="text-base text-black">x</button>
                                                                    </div>
                                                                    
                                                                    <section class="pt-20 pb-20 max-h-[650px] flex justify-center">
                                                                        <div style="padding:40px;width:500px">
                                                                            <form wire:submit.prevent="confirmUpdateMentoring({{ $m->student->username }})">
                                                                                <div class="w-full lg:mx-auto">
                                                                                    <div class="w-full mb-8 px-4">
                                                                                        <label for="time" class="text-base text-primary font-bold">Waktu*</label>
                                                                                        <input type="datetime-local" id="time" name="time" wire:model.lazy="time" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                                                        @error('time')
                                                                                            <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="w-full mb-8 px-4">
                                                                                        <label for="description" class="text-base text-primary font-bold">Keterangan*</label>
                                                                                        <input type="text" id="description" name="description" wire:model.lazy="description" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                                                        @error('description')
                                                                                            <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="w-full">
                                                                                        <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Kirim</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                            <form title="hapus" wire:submit.prevent="confirmCancelMentoring({{ $q->id }})">
                                                <button type="submit">
                                                    <div class="m-2 rounded-lg bg-red-500 p-1 hover:opacity-50 transition duration-400">
                                                        <img src="/src/img/icons/garbage.png"width="25px" alt="">
                                                    </div>
                                                </button>
                                            </form>
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

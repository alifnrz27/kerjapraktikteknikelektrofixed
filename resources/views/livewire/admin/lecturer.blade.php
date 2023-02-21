<div>
    <div class="w-full p-4 mb-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[2000px] overflow-auto">
        <div x-data="{open:false}" class="w-full self-center px-4 flex justify-between">
            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Pilih dospem</h1>
            <button @click="open=true">
                <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                    History
                </div>
            </button>
            <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-screen bg-black/50 flex justify-center items-center">
                <section @click.outside="open = false" id="history-lecturer" class="fixed w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto dark:bg-dark top-0 shadow-lg bg-primary" style="margin: auto;overflow:auto">
                    <div class="w-full p-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[2000px] overflow-auto">
                        <div class="w-full flex justify-between self-center px-4">
                            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">History</h1>
                            <button @click="open=false" class="text-base text-black">x</button>
                        </div>
                        
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        @if(count($lecturerHistory) == 0)
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
                                                @foreach($lecturerHistory as $s)
                                                <tr class="border-b">
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4">
                                                    {{ $s->user->name }}
                                                    </td>
                                                    <td class="text-sm text-gray-900 font-light px-6 py-4 flex">
                                                        <div x-data="{open:false}">
                                                            <button title="update" @click="open=true">
                                                                <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                                                                    <img src="{{asset('/src/img/icons/edit.png')}}" width="25px" alt="">
                                                                </div>
                                                            </button>

                                                            <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-screen bg-black/50 flex justify-center items-center">
                                                                <section @click.outside="open = false" id="update-mentor-{{ $s->user->username }}" class="fixed w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto dark:bg-darkshadow-lg bg-primary" style="margin: auto">
                                                                    <div class="w-full p-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
                                                                        <div class="w-full flex justify-between self-center px-4">
                                                                            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Update dospem untuk {{ $s->user->name }}</h1>
                                                                            <button @click="open=false" class="text-base text-black">x</button>
                                                                        </div>
                                                                        
                                                                        <section class="pt-36 pb-32 dark:bg-slate-900">
                                                                            <div class="container">        
                                                                                <form wire:submit.prevent="updateConfirm('{{$s->user->username}}', {{$s->id}})">
                                                                                    <div class="w-full lg:w-2/3 lg:mx-auto">
                                                                                        <div class="w-full mb-8 px-4">
                                                                                            <label for="mentor" class="text-base text-primary font-bold">Pilih dosen</label>
                                                                                            <select name="mentor" id="mentor" class="form-control" wire:model.lazy="mentor">
                                                                                                @foreach($mentors as $mentor)
                                                                                                    @if($s->lecturer_id == $mentor->id)
                                                                                                    <option value="{{ $mentor->username }}" selected>{{ $mentor->name }}</option>
                                                                                                    @else
                                                                                                    <option value="{{ $mentor->username }}">{{ $mentor->name }}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
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
                        @if(count($lecturer) == 0)
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
                                @foreach($lecturer as $l)    
                                <tr class="border-b">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4">
                                    {{ $l->user->name }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 flex">
                                        <div x-data="{open:false}">
                                            <button @click="open=true">
                                                <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                                                    <img src="{{asset('/src/img/icons/edit.png')}}" width="25px" alt="">
                                                </div>
                                            </button>
                                            <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-screen bg-black/50 flex justify-center items-center">
                                                <section @click.outside="open = false" id="choose-mentor-{{ $l->user->username }}" class="fixed w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto dark:bg-dark shadow-lg bg-primary" style="margin: auto">
                                                    <div class="w-full p-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
                                                        <div class="w-full flex justify-between self-center px-4">
                                                            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Masukkan dospem untuk {{ $l->user->name }}</h1>
                                                            <button @click="open=false" class="text-base text-black">x</button>
                                                        </div>
                                                        
                                                        <section class="pt-36 pb-32 dark:bg-slate-900">
                                                            <div class="container">        
                                                                <form wire:submit.prevent="acceptConfirmLecturer('{{ $l->user->username }}')">
                                                                    <div class="w-full lg:w-2/3 lg:mx-auto">
                                                                        <div class="w-full mb-8 px-4">
                                                                            <label for="mentor" class="text-base text-primary font-bold">Pilih dosen</label>
                                                                            <select name="mentor" id="mentor" wire:model.lazy="mentor" class="form-control">
                                                                                <option>Pilih</option>
                                                                                @foreach($mentors as $mentor)
                                                                                    <option value="{{ $mentor->username }}">{{ $mentor->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('mentor')
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

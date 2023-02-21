<div>
    @section('title', 'Users')
    <div class="w-11/12 lg:w-11/12 flex pb-32">
        <section id="student-register" class="w-full pt-6 pb-32 dark:bg-slate-900">
            <section class="pb-4">
                <div class="container flex justify-between">
                    <div class=" self-center px-4">
                        <h1 class="text-base font-semibold text-primary md:text-xl">Selamat Datang, <span class="block font-bold text-dark dark:text-white text-4xl lg:text-5xl">{{ auth()->user()->name }}</span></h1>
                        <h1 class="text-base font-semibold text-primary md:text-l">{{ date('d-M-Y') }}</h1>
                    </div>
                    <div class=" self-center px-4 hidden sm:block">
                        <h1 class="text-base font-semibold text-primary md:text-l">Kerja Praktik <span class="block font-bold text-dark dark:text-white text-4xl lg:text-2xl">Teknik Elektro</span></h1>
                        <h1 class="text-base font-semibold text-primary md:text-sm">ITERA</h1>
                    </div>
                </div>
                <hr>
            </section>
            <div class="container">
                <div class="w-full px-4">
                    <div class="mx-auto text-center mb-16">
                        <h4 class="font-semibold text-lg dark:text-white text-primary mb-2">All Users</h4>
                    </div>
                </div>
                
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                @if(count($users) == 0)
                                <div class="m-2 rounded-lg p-1 hover:opacity-50 transition duration-400">
                                    <img src="{{asset('/src/img/icons/undraw_no_data_re_kwbl.svg')}}" class="mx-auto" width="200px" alt="">
                                </div>
                                @else
                                <table class="min-w-full">
                                    <thead class="border-b">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 dark:text-white px-6 py-4 text-left">
                                        No
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 dark:text-white px-6 py-4 text-left">
                                        Nama
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 dark:text-white px-6 py-4 text-left">
                                            Role
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 dark:text-white px-6 py-4 text-left">
                                        Aksi
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr class="border-b">
                                            <td class="px-6 py-4 text-sm font-medium dark:text-white text-dark">{{ $loop->iteration }}</td>
                                            <td class="text-sm dark:text-white text-dark font-light px-6 py-4">
                                            {{ $user->name }}
                                            </td>
                                            <td class="text-sm dark:text-white text-dark font-light px-6 py-4">
                                                {{ $user->role->name }}
                                            </td>
                                            <td class="text-sm dark:text-white text-dark font-light px-6 py-4 flex">
                                                @if($user->active_id == 1)
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 flex">            
                                                    <div x-data={open:false}>
                                                        <button title="edit role" @click="open=true">
                                                            <div class="m-2 rounded-lg bg-primary p-1 hover:opacity-50 transition duration-400">
                                                                <img src="{{asset('/src/img/icons/edit.png')}}" width="25px" alt="">
                                                            </div>
                                                        </button>
            
                                                        <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-screen bg-black/50 flex justify-center items-center">
                                                            <section x-show="open"  @click.outside="open = false"  class="fixed w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto dark:bg-dark shadow-lg bg-primary" style="margin: auto">
                                                                <div class="w-full p-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
                                                                    <div class="w-full flex justify-between self-center px-4">
                                                                        <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Update role {{ $user->name }}</h1>
                                                                        <button @click="open=false" class="text-base text-black">x</button>
                                                                    </div>
                                                                    
                                                                    <section id="logbook" class="pt-36 pb-32 dark:bg-slate-900">
                                                                        <div class="container">        
                                                                            <form wire:submit.prevent="updateRole('{{$user->username}}')">
                                                                                <div class="w-full lg:w-2/3 lg:mx-auto">
                                                                                    <div class="w-full mb-8 px-4">
                                                                                        <label for="role_id" class="text-base text-primary font-bold">Role</label>
                                                                                        <select id="role_id" wire:model.lazy="role_id">
                                                                                            <option>Pilih</option>
                                                                                            @foreach($roles as $role)
                                                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('role_id')
                                                                                            <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="w-full">
                                                                                        <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Ubah</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>

                                                    @if($user->role_id == 3)
                                                    <button title="block user" type="submit" wire:click="deleteConfirm('{{$user->username}}')">
                                                        <div class="m-2 rounded-l p-1 hover:opacity-50 transition duration-400">
                                                            <img src="{{asset('/src/img/icons/stop.png')}}" width="25px" alt="">
                                                        </div>
                                                    </button>
                                                    @endif
                                                </td>
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

        <x-sidebar></x-sidebar>
    </div>
</div>

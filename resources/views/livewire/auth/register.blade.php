<div>
    @section('title', 'Create a new account')

    <div>
        <section id="contact" class="pt-36 pb-32 dark:bg-slate-900">
            <div class="container">
                <div class="w-full px-4">
                    <div class="mx-auto text-center mb-16">
                        <h4 class="font-semibold text-lg text-primary mb-2 dark:text-white">Daftar Pengguna</h4>
                        <h2 class="font-bold text-dark dark:text-white text-3xl mb-4 sm:text-4xl lg:text-5xl">Selamat Datang</h2>
                    </div>
                </div>

                <form wire:submit.prevent="register">
                    <div class="w-full lg:w-1/3 lg:mx-auto">
                        <div class="w-full mb-8 px-4">
                            <label for="name" class="text-base text-primary font-bold dark:text-white">Nama</label>
                            <input type="text" id="name" wire:model.lazy="name" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 absolute">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full mb-8 px-4">
                            <label for="email" class="text-base text-primary font-bold dark:text-white"">Email</label>
                            <input type="email" id="email" wire:model.lazy="email" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 absolute">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full mb-8 px-4">
                            <label for="password" class="text-base text-primary font-bold dark:text-white"">Password</label>
                            <input type="password" id="password" wire:model.lazy="password" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary"  required autocomplete="new-password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 absolute">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full mb-8 px-4">
                            <label for="password_confirmation" class="text-base text-primary font-bold dark:text-white"">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" wire:model.lazy="passwordConfirmation" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary"  required autocomplete="new-password">
                        </div>
                        <div class="w-full mb-8 px-4 flex">
                            <a class="underline text-sm text-gray-600 hover:text-primary" href="/login">
                                {{ __('Sudah memiliki akun? Login') }}
                            </a>
                        </div>
                        <div class="w-full">
                            <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Daftar</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

</div>

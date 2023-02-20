@section('title', 'Login')

<div>
    <section id="contact" class="w-full pt-40 pb-32 dark:bg-slate-900">
        <div class="container">
            <div class="w-full px-4">
                <div class="mx-auto text-center mb-16">
                    <h4 class="font-semibold text-lg text-primary text-white mb-2">Login</h4>
                    <h2 class="font-bold text-dark dark:text-white text-3xl mb-4 sm:text-4xl lg:text-5xl">Selamat Datang</h2>
                </div>
            </div>

    
            <form wire:submit.prevent="authenticate">
                <div class="w-full lg:w-1/3 mx-auto">
                    <div class="w-full mb-8 px-4">
                        <label for="email" class="text-base text-primary text-white font-bold">Email</label>
                        <input type="email" id="email" wire:model.lazy="email" value="{{ old('email') }}" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full mb-8 px-4">
                        <label for="password" class="text-base text-primary text-white font-bold">Password</label>
                        <input type="password" id="password" wire:model.lazy="password" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary"  required autocomplete="current-password">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="w-full mb-8 px-4 flex justify-between">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-primary" href="{{ route('password.request') }}">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                        <a class="underline text-sm text-gray-600 hover:text-primary" href="/register">
                            {{ __('Belum punya akun? Register') }}
                        </a>
                    </div>
                    <div class="w-full">
                        <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

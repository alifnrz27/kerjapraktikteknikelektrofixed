<div>
    <form wire:submit.prevent="confirmChangePassword" class="w-6/12 flex justify-center mx-auto bg-neutral-600 py-5 rounded">
        <div class="w-full lg:w-2/3 lg:mx-auto">
            <h2 class="font-bold text-dark dark:text-white text-xl mb-4">Change Password</h2>
            <div class="w-full mb-8 px-4">
                <label for="old_password" class="text-base text-primary font-bold">Password Lama*</label>
                <input type="password" id="old_password" name="old_password" wire:model.lazy="old_password" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                @error('old_password')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="new_password" class="text-base text-primary font-bold">Password Baru*</label>
                <input type="password" id="new_password" name="new_password" wire:model.lazy="new_password" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('new_password')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="confirm_password" class="text-base text-primary font-bold">Konfirmasi Password*</label>
                <input type="password" id="confirm_password" name="confirm_password" wire:model.lazy="confirm_password" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                @error('confirm_password')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full">
                <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Ganti</button>
            </div>
        </div>
    </form>
</div>

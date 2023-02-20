<div>
    <form wire:submit.prevent="confirmLetter">
        <div class="w-full lg:w-2/3 lg:mx-auto">
            <div class="w-full mb-8 px-4">
                <label for="replyFromMajor" class="text-base text-primary font-bold">Link Drive Surat dari Jurusan*</label>
                <input type="text" id="replyFromMajor" name="replyFromMajor" wire:model.lazy="replyFromMajor" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('replyFromMajor')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="replyFromCompany" class="text-base text-primary font-bold">Link Drive Balasan Instansi*</label>
                <input type="text" id="replyFromCompany" name="replyFromCompany" wire:model.lazy="replyFromCompany" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('replyFromCompany')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full">
                <button type="submit" class="text-base mb-4 font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Ajukan</button>
            </div>
        </div>
    </form>
</div>

<div>
    <form wire:submit.prevent="confirmStore">
        <div class="w-full lg:w-2/3 lg:mx-auto">
            <div class="w-full mb-8 px-4">
                <label for="place" class="text-base text-primary font-bold">Tampat KP*</label>
                <input type="text" id="place" name="place" wire:model.lazy="place" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                @error('place')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="name_leader" class="text-base text-primary font-bold">Nama Kepala Instansi*</label>
                <input type="text" id="name_leader" name="name_leader" wire:model.lazy="name_leader" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('name_leader')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="address" class="text-base text-primary font-bold">Alamat KP*</label>
                <input type="text" id="address" name="address" wire:model.lazy="address" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                @error('address')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="number" class="text-base text-primary font-bold">Nomor Telpon Instansi*</label>
                <input type="text" id="number" name="number" wire:model.lazy="number" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('number')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="transcript" class="text-base text-primary font-bold">Link Drive Transkrip Nilai*</label>
                <input type="text" id="transcript" name="transcript" wire:model.lazy="transcript" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('transcript')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="vaccine" class="text-base text-primary font-bold">Link Drive Sertifikat Vaksin*</label>
                <input type="text" id="vaccine" name="vaccine" wire:model.lazy="vaccine" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                @error('vaccine')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="form" class="text-base text-primary font-bold">Link Drive Form Pendaftaran*</label>
                <input type="text" id="form" name="form" wire:model.lazy="form" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('form')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="start" class="text-base text-primary font-bold">Tanggal Mulai*</label>
                <input type="date" id="start" name="start" wire:model.lazy="start" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required autofocus>
                @error('form')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full mb-8 px-4">
                <label for="end" class="text-base text-primary font-bold">Tanggal Selesai*</label>
                <input type="date" id="end" name="end" wire:model.lazy="end" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary" required>
                @error('end')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex mb-8">
                <span class="mr-2 text-sm text-slate-500 dark:text-white">Berkelompok ?</span>
                <input type="checkbox" class="" name="teamStatus" id="teamStatus" wire:model.lazy="teamStatus">
                <label for="teamStatus" id="label-team-status">
                    <div class="flex h-5 w-9 cursor-pointer items-center rounded-full bg-slate-500 p-1">
                        <div id="toggle-team-status" class=" h-4 w-4 rounded-full bg-white transition duration-300"></div>
                    </div>
                </label>
            </div>
            <div id="members-input" class=" w-full mb-8 px-4">
                <label for="members" class="text-base text-primary font-bold">Anggota Tim</label>
                <input type="text" id="members" name="members" value="{{ old('members') }}" wire:model.lazy="members" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                @error('members')
                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full">
                <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Register</button>
            </div>
        </div>
    </form>

    <script>
            const labelTeamStatus = document.querySelector('#label-team-status');
            const teamStatus = document.querySelector('#teamStatus');
            const input = document.querySelector('#members-input');
            labelTeamStatus.addEventListener('click', function(){
                if(teamStatus.checked) {
                    input.classList.add('hidden');
                }
                else{
                    input.classList.remove('hidden');
                }
            });

            // status
            const statusData = document.querySelector('#status');
            setTimeout(function(){
                statusData.style.display = 'none';
            }, 1000);

            
        </script>
</div>

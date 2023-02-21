<div>
    <div class="w-11/12 lg:w-11/12 flex pt-5 pb-32">
        @if(auth()->user()->active_id == 1)
            @if($submissionStatus >= 14 && $submissionStatus < 30)
            <div class="container">
                <div class="w-full px-4">
                    <div class="mx-auto text-center mb-16">
                        <h4 class="font-semibold text-lg text-primary mb-2">Selamat</h4>
                        <h2 class="font-bold text-dark dark:text-white text-3xl mb-4 sm:text-4xl lg:text-5xl">Kerja Praktik anda telah diterima</h2>
                    </div>
                </div>
                <div class="m-2 rounded-lg p-1">
                    <img src="{{asset('/src/img/icons/undraw_winners_re_wr1l.svg')}}" class="mx-auto hover:opacity-50 transition duration-400" width="200px" alt="">
                    <a href="/dashboard" type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-2/12 hover:opacity-80 hover:shadow-lg mt-4 block mx-auto transition duration-500 text-center">Kembali</a>
                </div>
            </div>
            @else
            <section id="student-register" class="w-full pt-36 pb-32 dark:bg-slate-900">
                <div class="container">
                    <div class="w-full px-4">
                        <div class="mx-auto text-center mb-16">
                            <h4 class="font-semibold text-lg text-primary mb-2">Selamat Datang</h4>
                            <h2 class="font-bold text-dark dark:text-white text-3xl mb-4 sm:text-4xl lg:text-5xl">Silahkan Daftar Kerja Praktik</h2>
                        </div>
                    </div>
                    
                    @if($submissionStatus == Null || $submissionStatus == 3 || $submissionStatus == 6 || $submissionStatus == 7 || $submissionStatus == 8)
                    <livewire:student.submission/>
                    @elseif($submissionStatus == 4 || $submissionStatus == 10 || $submissionStatus == 13)
                        <div class="w-full">
                            <div class="text-center">
                                <h1 class="text-base font-semibold text-center text-primary md:text-xl mx-auto mb-4">{{ $descriptionSubmissionStatus->name }}</h1>
                            </div>
                        </div>
                        @if($submissionStatus == 4)
                        <livewire:student.member-upload/>
                        @elseif($submissionStatus == 10 || $submissionStatus == 13)
                            <livewire:student.letter/>
                        @endif

                        <div class="w-2/12 mx-auto">
                            <form wire:submit.prevent="confirmCancel">
                            <button type="submit" class="text-base font-semibold text-white bg-red-500 py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Batalkan pengajuan</button>
                        </form>
                        </div>


                    @elseif($submissionStatus == 1 || $submissionStatus == 2 || $submissionStatus == 5 || $submissionStatus == 9 || $submissionStatus == 11 || $submissionStatus == 12)
                    <h1 class="text-base font-semibold text-primary md:text-xl text-center mx-auto mb-4">Status : {{ $descriptionSubmissionStatus->name }}</h1>
                        @if($submissionStatus == 2)
                            <livewire:student.invitation/> 
                        @endif
                    <div class="w-2/12 mx-auto">
                        <form wire:submit.prevent="confirmCancel">
                            <button type="submit" class="text-base font-semibold text-white bg-red-500 py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Batalkan pengajuan</button>
                        </form>
                    </div>
                    @endif
                </div>
            </section>
            @endif
        @else
        <div class="container">
            <div class="w-full px-4">
                <div class="mx-auto text-center mb-16">
                    <h2 class="font-bold text-dark dark:text-white text-3xl mb-4 sm:text-4xl lg:text-5xl">Anda tidak dapat mengisi pendaftaran</h2>
                </div>
            </div>
            <div class="m-2 rounded-lg p-1">
                <img src="{{asset('/src/img/icons/undraw_winners_re_wr1l.svg')}}" class="mx-auto hover:opacity-50 transition duration-400" width="200px" alt="">
                <a href="/dashboard" type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-2/12 hover:opacity-80 hover:shadow-lg mt-4 block mx-auto transition duration-500 text-center">Kembali</a>
            </div>
        </div>
        @endif

        <x-sidebar></x-sidebar>
    </div>

        

</div>

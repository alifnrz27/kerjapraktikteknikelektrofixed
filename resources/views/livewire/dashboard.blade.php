<div>
    @section('title', 'Dashboard')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="w-11/12 lg:w-11/12 flex pt-5 pb-32">
            <div class="w-11/12 lg:w-full dark:text-white">
                <section class="py-4">
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

                <livewire:card :academicYear="$academicYear"/>
                @if(auth()->user()->role_id == 1)
                    <div id="admin">
                        <livewire:admin.register :academicYear="$academicYear"/>
                        <livewire:admin.letter-major :academicYear="$academicYear"/>
                        <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                            <livewire:admin.lecturer :academicYear="$academicYear"/>
                        </div>
                        <livewire:admin.before-presentation :academicYear="$academicYear"/>
                        <livewire:admin.after-presentation :academicYear="$academicYear"/>
                        <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                            <livewire:admin.hard-copy :academicYear="$academicYear"/>
                            <livewire:admin.status :academicYear="$academicYear"/>
                        </div>
                    </div>

                @elseif(auth()->user()->role_id == 2)
                <div id="lecturer">
                    <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                        <livewire:lecturer.mentoring/>
                        <livewire:lecturer.mentoring-queue/>
                    </div>

                    <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                        <livewire:lecturer.title/>
                        <livewire:lecturer.report/>
                    </div>

                    <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                        <livewire:lecturer.presentation/>
                        <livewire:lecturer.presentation-queue/>
                    </div>

                    <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3 justify-center">
                        <livewire:lecturer.evaluate/>
                        <livewire:lecturer.student :academicYear="$academicYear"/>
                    </div>
                </div>

                @elseif(auth()->user()->role_id == 3)
                    <div id="student">
                        @if($submissionStatus != Null)
                        <div class="flex">
                            @if($submissionStatus == 18 || $submissionStatus == 20)  
                            <livewire:student.before-presentation/>
                            @endif
                            @if($submissionStatus == 21)
                            <livewire:student.presentation/>
                            @endif
                            @if($submissionStatus == 24 || $submissionStatus == 25 || $submissionStatus == 27)  
                            <livewire:student.after-presentation/>
                            @endif
                        </div>
                        
                        @if($submissionStatus >=15)
                        <livewire:student.logbook/>
                        <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                        <livewire:student.mentoring :submissionStatus="$submissionStatus"/>
                        <livewire:student.title :submissionStatus="$submissionStatus"/>
                        </div>

                        <div class="flex flex-wrap bg-gray-100 dark:bg-dark rounded-lg py-7 px-3">
                        <livewire:student.report :submissionStatus="$submissionStatus"/>
                        </div>
                        @endif

                        @else
                        <a href="/student-register" class="block justify-center text-center mx-auto text-base font-semibold text-white mb-3 bg-primary py-3 px-4 rounded-full hover:opacity-80 hover:shadow-lg transition duration-500 w-2/12">Silahkan daftar</a>
                        @endif
                    </div>
                @endif
            </div>

            <x-sidebar/>

        </div>
    </div>
</div>

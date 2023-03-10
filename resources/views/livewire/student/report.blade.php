<div>
    <div class="w-full p-4 mb-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
        <div class="w-full self-center px-4 flex justify-between">
            <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Pengajuan Laporan</h1>
            @if($submissionStatus < 30)
                <div x-data={open:false}>
                    <button @click="open=true">
                        <div class="m-2 rounded-lg  min-w-[150px] bg-primary p-3 hover:opacity-50 transition text-white duration-400">
                            Ajukan
                        </div>
                    </button>
                    <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-screen bg-black/50 flex justify-center items-center">
                        <section @click.outside="open = false" x-show="open" class="fixed w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto shadow-lg bg-blue-400 max-h-[700px]" style="margin: auto">
                            <div class="w-full p-4 bg-white rounded-lg max-h-[650px] overflow-hidden">
                                <div class="w-full flex justify-between self-center px-4">
                                    <h1 class="text-base font-semibold text-blue-400 md:text-xl mb-5">Ajukan Laporan</h1>
                                    <button @click="open=false" class="text-base text-black">x</button>
                                </div>
                                
                                <section class="pt-20 pb-20 max-h-[650px] overflow-auto relative">
                                    <div class="container">  
                                        <form wire:submit.prevent="confirmAddReport">
                                            <div class="w-full lg:w-2/3 lg:mx-auto">
                                                <div class="w-full mb-8 px-4">
                                                    <label for="report" class="text-base text-blue-400 font-bold">Link Drive Laporan</label>
                                                    <input type="text" id="report" name="report" wire:model="report" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                    @error('report')
                                                        <p class="mt-1 text-sm text-red-600 relative">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="w-full">
                                                    <button type="submit" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full w-full hover:opacity-80 hover:shadow-lg transition duration-500">Ajukan</button>
                                                </div>
                                            </div>
                                        </form> 
                                    </div>
                                </section>
                            </div>
                        </section>
                    </div>
                </div>
            @endif
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        @if(count($reports) == 0)
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
                                Link
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Keterangan
                                    </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($reports as $report)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="text-gray-900 font-light py-4">
                                            <a title="laporan" href="{{ $report->report }}" target="_blank" class="">
                                                <div class="m-2 rounded-lg hover:opacity-50 transition duration-400">
                                                    <img src="{{asset('/src/img/icons/report.png')}}" width="25px" alt="">
                                                </div>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $report->description }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4">
                                            {{ $reportStatus[$report->report_status_id - 1]->name }}
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

    @if($submissionStatus < 30)
    <section id="add-report" class="fixed hidden w-full lg:w-4/12 p-3 mb-5 mx-auto my-auto dark:bg-dark top-0 shadow-lg bg-primary" style="margin: auto">
        <div class="w-full p-4 bg-white dark:bg-secondary rounded-lg h-full max-h-[1000px] overflow-auto">
            <div class="w-full flex justify-between self-center px-4">
                <h1 class="text-base font-semibold text-primary dark:text-white md:text-xl">Ajukan Laporan</h1>
                <button onclick="sembunyiPopup('add-report')" class="text-base text-black">x</button>
            </div>
            
            <section id="logbook" class="pt-36 pb-32 dark:bg-slate-900">
                <div class="container">        
                    <form action="/report/add" method="POST">
                        @csrf
                        <div class="w-full lg:w-2/3 lg:mx-auto">
                            <div class="w-full mb-8 px-4">
                                <label for="report" class="text-base text-primary font-bold">Link Drive Laporan</label>
                                <input type="text" id="report" name="report" value="{{ old('report') }}" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
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
    @endif
</div>

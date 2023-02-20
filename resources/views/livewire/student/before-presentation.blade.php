<div>
    <div class="w-full self-center px-4 flex justify-end"  x-data="{open: false}">
        <div x-data={open:false}>
            <button @click="open=true">
                <div class="m-2 rounded-lg  min-w-[150px] bg-primary p-3 hover:opacity-50 transition text-white duration-400">
                    Sebelum presentasi
                </div>
            </button>
            <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-full bg-black/50 flex justify-center items-center">
                    <section @click.outside="open = false" x-show="open" class="fixed lg:w-4/12 p-3 mb-5 mx-auto my-auto shadow-lg bg-blue-400 max-h-[700px]" style="margin: auto">
                        <div class="w-full p-4 bg-white rounded-lg max-h-[650px] overflow-hidden">
                            <div class="w-full flex justify-between self-center px-4">
                                <h1 class="text-base font-semibold text-blue-400 md:text-xl">Tambahkan Berkas Pengajuan</h1>
                                <button @click="open=false" class="text-base text-black">x</button>
                            </div>
                            
                            <section class="pt-20 pb-20 max-h-[650px] flex justify-center">
                                <div style="padding:40px;width:500px">
                                    <form wire:submit.prevent="confirmAddBeforePresentation">
                                        <div class="w-full lg:mx-auto">
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive form pendaftaran*</label>
                                                <input type="form_presentation" id="form_presentation" name="form_presentation" wire:model.lazy="form_presentation" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('form_presentation')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive penilaian dari perusahaan*</label>
                                                <input type="result_company" id="result_company" name="result_company" wire:model.lazy="result_company" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('result_company')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive logbook*</label>
                                                <input type="log_activity" id="log_activity" name="log_activity" wire:model.lazy="log_activity" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('log_activity')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive penilaian bimbingan*</label>
                                                <input type="form_mentoring" id="form_mentoring" name="form_mentoring" wire:model.lazy="form_mentoring" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('form_mentoring')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive laporan*</label>
                                                <input type="report" id="report" name="report" wire:model.lazy="report" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('report')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive SS Pengumpulan*</label>
                                                <input type="screenshot_before_presentation" id="screenshot_before_presentation" name="screenshot_before_presentation" wire:model.lazy="screenshot_before_presentation" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('screenshot_before_presentation')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive surat pernyataan</label>
                                                <input type="statement_letter" id="statement_letter" name="statement_letter" wire:model.lazy="statement_letter" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('statement_letter')
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
        </div>
    </div>
</div>

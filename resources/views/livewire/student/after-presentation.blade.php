<div>
    <div class="w-full self-center px-4 flex justify-end"  x-data="{open: false}">
        <div x-data={open:false}>
            <button @click="open=true">
                <div class="m-2 rounded-lg  min-w-[150px] bg-primary p-3 hover:opacity-50 transition text-white duration-400">
                    Setelah presentasi
                </div>
            </button>
            <div x-cloak x-show="open" x-transition class="fixed top-0 left-0 w-full h-full bg-black/50 flex justify-center items-center">
                    <section @click.outside="open = false" x-show="open" class="fixed lg:w-4/12 p-3 mb-5 mx-auto my-auto shadow-lg bg-blue-400 max-h-[700px]" style="margin: auto">
                        <div class="w-full p-4 bg-white rounded-lg max-h-[650px] overflow-hidden">
                            <div class="w-full flex justify-between self-center px-4">
                                <h1 class="text-base font-semibold text-blue-400 md:text-xl">Tambahkan Berkas Pengajuan Pasca Presentasi</h1>
                                <button @click="open=false" class="text-base text-black">x</button>
                            </div>
                            
                            <section class="pt-20 pb-20 max-h-[650px] flex justify-center">
                                <div style="padding:40px;width:500px">
                                    <form wire:submit.prevent="confirmAddAfterPresentation">
                                        <div class="w-full lg:mx-auto">
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive berita acara*</label>
                                                <input type="report_of_presentation" id="report_of_presentation" name="report_of_presentation" wire:model.lazy="report_of_presentation" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('report_of_presentation')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive notulensi*</label>
                                                <input type="notes" id="notes" name="notes" wire:model.lazy="notes" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('notes')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive revisi laporan*</label>
                                                <input type="report_revision" id="report_revision" name="report_revision" wire:model.lazy="report_revision" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('report_revision')
                                                    <p class="mt-2 text-sm text-red-600 fixed">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="w-full mb-8 px-4">
                                                <label for="text" class="text-base text-primary font-bold">Link drive SS pengumpulan berkas*</label>
                                                <input type="screenshot_after_presentation" id="screenshot_after_presentation" name="screenshot_after_presentation" wire:model.lazy="screenshot_after_presentation" class="w-full bg-slate-200 text-dark p-3 rounded-md focus:outline-none focus:ring-primary focus:ring-1 focus:border-primary">
                                                @error('screenshot_after_presentation')
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

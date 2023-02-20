<div>
    <section class="py-5 rounded-lg bg-gray-100 dark:bg-dark mb-4">
        <div>
            <div 
                x-data="{
                        textCards:{{$textCards}},
                        cards:{{$cards}}
                        }"
                class="flex flex-wrap"
                >
                <template x-for="(card, index) in cards">
                    <div class="w-1/2 px-4 lg:w-1/4">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10 lg:mb-1 dark:bg-slate-600">
                            <div class="py-8 px-6">
                                <p x-text="textCards[index]" class="block  mb-3 font-semibold text-xl text-primary dark:text-white hover:text-primary truncate"></p>
                                <p x-text="card" class="font-medium text-base text-secondary mb-6"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</div>

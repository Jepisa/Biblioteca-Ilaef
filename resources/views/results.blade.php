<x-app-layout>
    <div class="background_color_main"></div>
    <x-slot name="css">
        <link rel="stylesheet" href=".">
    </x-slot>

    <x-slot name="scripts">
    </x-slot>

    <div class="flex flex-col w-full justify-center items-center 2xl:px-40 xl:px-30 sm:px-10 sm:py-8 px-4 py-4 color_grisclaro redhat_regular results_container">
        <div class="border_gris rounded-lg grid grid-cols-12 xl:gap-20 sm:gap-10 gap-2 flex 2xl:p-20 sm:p-10 p-4 lg:w-3/5 xl:w-full">
            <div class="sm:col-span-6 xl:col-span-3 col-span-6 flex-col justify-between">
                <x-book-details_legals />
                {{-- <div class=" flex xl:hidden flex-col justify-end mt-10">
                    <x-regular-text textContent="Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore nihil, perferendis accusamus deserunt laudantium nisi exercitationem sequi cumque? Provident neque officia veniam ducimus illo repudiandae, qui odio reiciendis nulla doloribus nisi! Culpa reprehenderit obcaecati quis ullam ipsam illum consectetur, recusandae laudantium mollitia ea. Velit consequuntur cupiditate commodi tenetur iusto. Culpa quis vel voluptatem necessitatibus id ea quos, quasi facilis laboriosam, doloribus mollitia officia sunt in inventore magnam deserunt nemo distinctio vitae sit aliquid soluta quae! In itaque ipsa, quos praesentium deserunt quidem nulla similique suscipit, quaerat nesciunt quod." />
                    <x-action-buttons />
                </div> --}}
            </div>
            <div class="sm:col-span-6 xl:col-span-3 lg:col-span-6 md:col-span-4 md:col-start-9 col-span-6 sm:ml-0 ml-5 ">
                <img src="{{ asset('img/content/0.jpg') }}" alt="" class="w-full" />
            </div>
            <div class="col-span-12 xl:col-span-6 xl:flex flex-col justify-end xl:mt-10 sm:mt-0 mt-10">
                <x-regular-text textContent="Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore nihil, perferendis accusamus deserunt laudantium nisi exercitationem sequi cumque? Provident neque officia veniam ducimus illo repudiandae, qui odio reiciendis nulla doloribus nisi! Culpa reprehenderit obcaecati quis ullam ipsam illum consectetur, recusandae laudantium mollitia ea. Velit consequuntur cupiditate commodi tenetur iusto. Culpa quis vel voluptatem necessitatibus id ea quos, quasi facilis laboriosam, doloribus mollitia officia sunt in inventore magnam deserunt nemo distinctio vitae sit aliquid soluta quae! In itaque ipsa, quos praesentium deserunt quidem nulla similique suscipit, quaerat nesciunt quod." />
                <x-action-buttons />
            </div>
        </div>
        <a href="/" class="mb-4 sm:mb-0 sm:w-20 w-12">
            <x-button-back class="mx-auto mt-8 text-white w-full" height="90" width="90" />
        </a>
    </div>


    {{-- <x-description /> --}}

</x-app-layout>

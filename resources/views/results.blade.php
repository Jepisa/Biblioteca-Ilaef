<x-app-layout>
    <div class="background_color_main"></div>
    <x-slot name="css">
        <link rel="stylesheet" href=".">
    </x-slot>

    <x-slot name="scripts">
    </x-slot>

    <div
        class="flex flex-col w-full justify-center items-center 2xl:px-40 xl:px-30 sm:px-10 sm:py-8 px-4 py-4 color_grisclaro redhat_regular">
        <div class="border_gris rounded-lg grid grid-cols-12 gap-20 flex 2xl:p-20 xl:p-10">
            <x-book-details_legals class="col-span-3" />
            <div class="col-span-3">
                <img src="{{ asset('img/content/0.jpg') }}" alt="" class="w-full"/>
            </div>
            <div class="col-span-6 flex flex-col justify-end">
                <x-regular-text
                    textContent="Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore nihil, perferendis accusamus deserunt laudantium nisi exercitationem sequi cumque? Provident neque officia veniam ducimus illo repudiandae, qui odio reiciendis nulla doloribus nisi! Culpa reprehenderit obcaecati quis ullam ipsam illum consectetur, recusandae laudantium mollitia ea. Velit consequuntur cupiditate commodi tenetur iusto. Culpa quis vel voluptatem necessitatibus id ea quos, quasi facilis laboriosam, doloribus mollitia officia sunt in inventore magnam deserunt nemo distinctio vitae sit aliquid soluta quae! In itaque ipsa, quos praesentium deserunt quidem nulla similique suscipit, quaerat nesciunt quod." />
                <x-action-buttons/>
            </div>
        </div>
        <a href="/" class="mb-4 sm:mb-0 w-20">
          <x-button-back class="mx-auto mt-8 text-white w-full" height="90" width="90"/>
      </a>
    </div>

    {{-- <x-description /> --}}

</x-app-layout>

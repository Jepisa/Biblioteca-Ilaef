<div class="flex h-full flex-col justify-center items-center lg:px-20 sm:px-10 sm:py-10 px-4 py-4 ">
    @isset($logo)
        <div class="mb-4 w-full px-10 flex justify-center lg:justify-start">
            {{ $logo }}
        </div>
    @endisset

    {{ $slot }}

</div>

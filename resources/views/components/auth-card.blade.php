<div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100 px-20">
    <div class="w-30">
        {{ $logo }}
    </div>

    <div class="border-2 border-gray-500 rounded-lg w-full flex justify-end p-20 mx-20">
        <div class="w-full sm:max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg p-10">
            {{ $slot }}
        </div>
    </div>
</div>

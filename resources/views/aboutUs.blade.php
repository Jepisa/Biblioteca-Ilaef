<x-app-layout>
    <x-slot name="scripts">
        <script src="{{ asset('js/glide.min.js') }}"></script>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js"
                integrity="sha512-y3NiupaD6wK/lVGW0sAoDJ0IR2f3+BWegGT20zcCVB+uPbJOsNO2PVi09pCXEiAj4rMZlEJpCGu6oDz0PvXxeg=="
                crossorigin="anonymous"></script>
    </x-slot>
    <div class="aboutUs_container">
        <div class="background_color"></div>
        <div class="background_aboutUs"></div>

        <div
            class="flex h-full flex-col justify-center items-center lg:px-20 sm:px-10 sm:py-8 px-4 py-4 color_grisclaro redhat_regular">
            <div
                class="border_gris rounded-lg w-full h-full lg:h-full flex flex-col justify-end items-end p-4 sm:p-10 xl:p-14 2xl:p-20 mx-4 sm:mx-10 xl:p-14 2xl:mx-20 xl:mx-14">
                <div class="px-0 sm:px-5 xl:px-8 2xl:px-10 h-fit 2xl:w-1/2 xl:w-7/12 lg:w-1/2 w-full text_AboutUsContainer">
                    <x-title class="pt-60 sm:pt-0 text-3xl sm:text-4xl lg:text-5xl" textContent="Quienes somos" />
                    <x-regular-text class="mt-2 aboutUs_text"
                        textContent="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit, omnis. Delectus, facilis nulla debitis nemo quaerat veniam quo, ipsa provident et quae adipisci enim deserunt optio eligendi sit amet consectetur adipisicing elit. Impedit, omnis. Delectus, facilis nulla debitis nemo quaerat veniam quo, ipsa provident et quae adipisci enim deserunt optio eligendi architecto consequatur voluptatem.               
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit, omnis. Delectus, facilis nulla debitis nemo quaerat veniam quo, ipsa provident et quae adipisci enim deserunt optio eligendi architecto consequatur vi enim deserunt optio eligendi architecto consequatur voluptatem.               
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit, omnis. D ipsum dolor, sit amet consectetur adipisicing elit. Impedit, omnis. Delectus, facilis nulla debitis nemo quaerat veniam" />
                    <div class="latinoAmerica_image_container">
                        <img class='latinoAmerica_image' src="{{ asset('/img/assets/aboutUs/latinoamerica.jpg') }}"
                            alt="ilustracion latinoamerica">
                    </div>
                </div>
            </div>
            <a href="/" class="mb-4 sm:mb-0 2xl:w-32 w-20">
                <x-button-back class="mx-auto mt-8 text-white w-full" height="90" width="90"/>
            </a>
        </div>

    </div>

</x-app-layout>

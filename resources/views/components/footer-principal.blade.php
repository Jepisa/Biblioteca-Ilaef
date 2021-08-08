    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    <footer class="grid grid-cols-12 bg-black xl:px-20 sm:px-10 px-5 mt-auto">
        <div class="xl:hidden md:col-span-3 col-span-12 lg:col-span-3 flex justify-left items-center">
            <div class="mt-2 logo_container_footer">
                <a class="" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo-letras-blancas.png') }}">
                </a>
            </div>
        </div>

        <div class="contact_container col-span-8 md:col-span-6 lg:col-span-6 flex flex-col lg:flex-row lg:justify-start md:justify-center justify-start lg:items-center items-left text-white redhat_regular lg:mx-0 md:mx-auto mx-0">
            <div class="flex">
                <div class="mr-2">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>201 Ahambra Circle Suite 1205 Coral Gables, FL33134</div>
            </div>
            <div class="flex lg:ml-10 mt-1 sm:mt-2 lg:mt-0">
                <div class="mr-2"><i class="fas fa-phone-alt"></i></div>
                <div> <a href="+54 9 11 5745-0859">11 5745-0859</a> </div>
            </div>
        </div>

        <div class="md:col-span-4 col-span-12 lg:col-span-3 xl:flex justify-center items-center hidden">
            <div class="mt-2 logo_container_footer xl:w-3/4">
                <a class="" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo-letras-blancas.png') }}">
                </a>
            </div>
        </div>

        <div class="md:col-span-3 col-span-4 lg:col-span-3 flex justify-end md:items-center items-start">
            <a href="" class="w-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 ml-2 lg:ml-4">
                <img class="" src="{{ asset('img/redes-sociales/icono-facebook.png') }}">
            </a>
            <a href="" class="w-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 ml-2 lg:ml-4">
                <img class="" src="{{ asset('img/redes-sociales/icono-twitter.png') }}">
            </a>
            <a href="" class="w-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 ml-2 lg:ml-4">
                <img class="" src="{{ asset('img/redes-sociales/icono-instagram.png') }}">
            </a>
            <a href="" class="w-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 ml-2 lg:ml-4">
                <img class="" src="{{ asset('img/redes-sociales/icono-linkedin.png') }}">
            </a>
            {{-- <i class="fab fa-facebook-square"></i></a>
                <a href=""><i class="fab fa-twitter-square"></i></a>
                <a href=""><i class="fab fa-instagram-square"></i></a>
                <a href=""><i class="fab fa-linkedin"></i></a> --}}
        </div>

    </footer>

<x-app-layout>
    <div class="background_aboutUs absolute xl:hidden block top-0 w-full md:h-2/5 h-1/2 z-1"></div>
    <div class="background_container lg:fixed lg:h-screen fixed overflow-hidden flex xl:flex-row flex-col">
        <div class="background_aboutUs h-full w-full xl:w-1/2 fade-in-1_2 xl:block hidden"></div>
        <div class="background_azuloscuro 2xl:w-7/12 xl:w-9/12 h-full block"></div>
    </div>
    <x-slot name="scripts">
        <script src="{{ asset('js/glide.min.js') }}"></script>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js"
                integrity="sha512-y3NiupaD6wK/lVGW0sAoDJ0IR2f3+BWegGT20zcCVB+uPbJOsNO2PVi09pCXEiAj4rMZlEJpCGu6oDz0PvXxeg=="
                crossorigin="anonymous"></script>
    </x-slot>



    <div
        class="flex h-full flex-col justify-center items-center lg:px-20 sm:px-10 sm:py-8 px-4 py-4 color_grisclaro redhat_regular 2xl:mt-12 aboutUs_container text-xs lg:text-base">
        <div
            class="border_gris rounded-lg w-full h-full lg:h-full flex flex-col justify-end items-end p-4 sm:p-10 xl:p-14 2xl:p-20 mx-4 sm:mx-10 xl:p-14 2xl:mx-20 xl:mx-14">
            <div class="px-3 sm:px-5 xl:px-8 2xl:px-10 h-fit 2xl:w-1/2 xl:w-7/12 w-full text_AboutUsContainer">
                <x-title class=" sm:pt-0 text-3xl sm:text-4xl lg:text-5xl md:pt-0 pt-60" textContent="Quienes somos" />
                <p class="mt-4 letterSpace-20">

                    Es un logro alcanzado por ILAEF , una idea impulsada por el socio protector IADEF, ofrecer un
                    sistema bibliotecario de Empresa Familiar con una base de datos a través de la cual encontrar
                    rápidamente lo que se busque en relación con el conocimiento de Empresa Familiar. El alto valor
                    agregado y diferencial del buscador y base de datos de la biblioteca de Empresa Familiar ILAEF
                    favorece seguir construyendo cultura de empresa familiar en la región latinoamericana,
                    visibilizando, promoviendo y potenciando la generación de conocimientos, la transmisión de
                    experiencias y buenas prácticas.<br>
                    Empresas familiares, consultores de empresas familiares, profesionales, investigadores,
                    académicos, practitioners, comunidad educativa de universidades, instituciones y organismos
                    internacionales encontraran, en este único lugar, la más amplia variedad de contenidos en
                    libros, ebooks, podcast, artículos, entrevistas, trabajos de investigaciones, casos de estudios,
                    tesis, materiales de congresos, seminarios, conferencias, audiovisuales, revistas, infografías y
                    piezas gráficas.<br>
                    Biblioteca de Empresa Familiar ILAEF<br>
                    JUNTA DIRECTIVA ILAEF



                </p>
                <div
                    class="md:w-40 xl:w-40 2xl:w-48 md:absolute md:right-20 lg:right-32 xl:right-40 2xl:right-40 xl:-mt-6 2xl:-mt-2 md:-mt-10 lg:-mt-6 w-full p-10 md:px-0">
                    <img class='latinoAmerica_image rounded-lg'
                        src="{{ asset('/img/assets/aboutUs/latinoamerica.jpg') }}" alt="ilustracion latinoamerica">
                </div>
            </div>
        </div>
    </div>

    <div class="w-full items-center justify-center flex mb-8 2xl:mt-4 xl:-mt-2 lg:mt-4">
        <div class="2xl:w-1/3 xl:w-1/4 block xl:block hidden"></div>
        <a href="{{ url()->previous() }}" class="xl:w-1/2 xl:pr-20 block">
            <x-button-back class="mx-auto text-white w-20" color="#d5e5e3" />
        </a>
    </div>




</x-app-layout>

<x-app-layout>
    <x-slot name="scripts">
        <script src="{{ asset('js/glide.min.js') }}"></script>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js" integrity="sha512-y3NiupaD6wK/lVGW0sAoDJ0IR2f3+BWegGT20zcCVB+uPbJOsNO2PVi09pCXEiAj4rMZlEJpCGu6oDz0PvXxeg==" crossorigin="anonymous"></script>
    </x-slot>

    <x-carousel-of-advertisement/>
    <x-searcher/>

    <x-carousel :titleOfCarousel="'Nuestros recomendados'" :carousel="'nuestros-recomendados'" :books="$books"/>
    <x-carousel :titleOfCarousel="'Los más buscados'" :carousel="'los-más-buscados'" :books="$books"/>
    <x-carousel :titleOfCarousel="'Los últimos cargados'" :carousel="'los-últimos-cargados'" :books="$books"/>


    <x-slot name="scriptsDown">
        <script>
            const configA = {
                type: 'carousel',
                perView: 1,
                startAt: 0,
                hoverpause: true,
                animationDuration: 3000,
                autoplay: 3000,
              };
              
              
            new Glide('.carousel-of-advertisement', configA).mount();
            
            document.addEventListener("DOMContentLoaded", function(event) {
                let carrouselYes = document.querySelectorAll(".imagen-carousel");
                for (let i = 0; i < carrouselYes.length; i++) {
                    carrouselYes[i].classList.remove("none-carrousel");
                }
                
              });
            
              
            const config = {
                type: 'carousel',
                perView: 11,
                startAt: 0,
                gap: 10,
                //autoplay: 4000,
                breakpoints: {
                    1024: {
                        perView: 8
                        },
                    768: {
                    perView: 4
                  },
                  480: {
                    perView: 3.5
                  },
                }
              };
              
              
            new Glide('.nuestros-recomendados ', config).mount();
            new Glide('.los-más-buscados', config).mount();
            new Glide('.los-últimos-cargados', config).mount();

        </script>
        <script>
            $('.title-of-book').dotdotdot();
        </script>
    </x-slot>
</x-app-layout>

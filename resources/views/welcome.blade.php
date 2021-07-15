<x-app-layout>
  <x-slot name="css">
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glide.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/glide.theme.min.css') }}">
  </x-slot>
    
  <x-slot name="scripts">
      <script src="{{ asset('js/glide.min.js') }}"></script>
      <script src="{{ asset('js/jquery.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js" integrity="sha512-y3NiupaD6wK/lVGW0sAoDJ0IR2f3+BWegGT20zcCVB+uPbJOsNO2PVi09pCXEiAj4rMZlEJpCGu6oDz0PvXxeg==" crossorigin="anonymous"></script>
  </x-slot>

  @if ($advertisements->count() > 0)
    <x-carousel-of-advertisement :advertisements="$advertisements"/>
  @endif
  {{-- <x-carousel-of-advertisement/> --}}


  <x-searcher/>

  {{-- @if($recommended->count() > 0) <x-carousel :titleOfCarousel="'Nuestros recomendados'" :carousel="'nuestros-recomendados'" :contents="$recommended" /> @endif --}}
  @if($relevant->count() > 0) <x-carousel :titleOfCarousel="'Los más buscados'" :carousel="'los-mas-buscados'" :contents="$relevant"/> @endif
  @if($recent->count() > 0) <x-carousel :titleOfCarousel="'Los últimos cargados'" :carousel="'los-ultimos-cargados'" :contents="$recent"/> @endif
  
  <x-slot name="scriptsDown">
      <script src="{{ asset('js/carousels.js') }}"></script>
      <script>
          $('.title-of-content').dotdotdot();
      </script>
  </x-slot>
</x-app-layout>

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


  <x-searcher/>

  <x-all-results/>

  <x-slot name="scriptsDown">
      <script src="{{ asset('js/carousels.js') }}"></script>
      <script>
          $('.title-of-content').dotdotdot();
      </script>
  </x-slot>
</x-app-layout>
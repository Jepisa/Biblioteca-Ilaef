<div class="carousel">
    <div class="title-of-carousel">
        {{ $titleOfCarousel }}
    </div>
    <div class="glide {{ $carousel }}">
        <div class="glide__track" data-glide-el="track">
        <ul  class="glide__slides">
            {{-- @foreach ($books as $book)                
                <li class="glide__slide">
                    <div class="div-slide">
                        <div class="image bg-gray-100">
                            <img id="imagenes-carousel" class="none-carrousel" src="{{ asset('storage/'.$book->coverImage) }}" alt="{{ $book->title }}">
                        </div>
                        <div class="title-of-book">
                            <p title="{{ $book->title }}">{{ $book->title }}</p>
                        </div>
                    </div>
                </li>
            @endforeach --}}
            @for ($i = 0; $i <= 17; $i++)           
                <li class="glide__slide">
                    <div class="div-slide">
                        <div class="image bg-gray-100">
                            <img id="imagenes-carousel" class="none-carrousel" src="{{ asset('img/content/'.$i.'.jpg') }}" alt="{{ 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magnam.' }}">
                        </div>
                        <div class="title-of-book">
                            <p title="{{ 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magnam.' }}">{{ 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magnam.' }}</p>
                        </div>
                    </div>
                </li>
            @endfor
        </ul>
        </div>
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left principal" data-glide-dir="<">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 240.823 240.823" style="enable-background:new 0 0 240.823 240.823;" xml:space="preserve">
                    <g>
                        <path id="Chevron_Right" d="M57.633,129.007L165.93,237.268c4.752,4.74,12.451,4.74,17.215,0c4.752-4.74,4.752-12.439,0-17.179
                            l-99.707-99.671l99.695-99.671c4.752-4.74,4.752-12.439,0-17.191c-4.752-4.74-12.463-4.74-17.215,0L57.621,111.816
                            C52.942,116.507,52.942,124.327,57.633,129.007z"/>
                    </g>
                </svg>
                        
            </button>
            <button class="glide__arrow glide__arrow--right principal" data-glide-dir=">">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 240.823 240.823" style="enable-background:new 0 0 240.823 240.823;" xml:space="preserve">
                        <g>
                            <path id="Chevron_Right_1_" d="M183.189,111.816L74.892,3.555c-4.752-4.74-12.451-4.74-17.215,0c-4.752,4.74-4.752,12.439,0,17.179
                                l99.707,99.671l-99.695,99.671c-4.752,4.74-4.752,12.439,0,17.191c4.752,4.74,12.463,4.74,17.215,0l108.297-108.261
                                C187.881,124.315,187.881,116.495,183.189,111.816z"/>
                        </g>
                </svg>
            </button>
        </div>
    </div>
</div>
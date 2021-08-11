@props([
    'fav' => '0',
    'contentID' => null,
])

<div class="modal_inner flex flex-col items-center justify-center">
    @guest
        <div class="flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" id='smile-register' enable-background="new 0 0 24 24" height="50"
                viewBox="0 0 24 24" width="50">
                <rect fill="none" height="24" width="24" />
                <path
                    d="M12,4c4.41,0,8,3.59,8,8s-3.59,8-8,8s-8-3.59-8-8S7.59,4,12,4 M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10 S17.52,2,12,2L12,2z M10,11V8c0-0.55-0.45-1-1-1h0C8.45,7,8,7.45,8,8v3c0,0.55,0.45,1,1,1h0C9.55,12,10,11.55,10,11z M16,11V8 c0-0.55-0.45-1-1-1h0c-0.55,0-1,0.45-1,1v3c0,0.55,0.45,1,1,1h0C15.55,12,16,11.55,16,11z M14,16c0-1.1-0.9-2-2-2h0 c-1.1,0-2,0.9-2,2v2h4V16z" />
            </svg>
        </div>
        <p class="font-bold text-base md:text-center text-sm">
            Necesitamos que te registres para que puedas guardar en favoritos.
        </p>
    @endguest
    @auth
        <div class="flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" id='favorites' height="50" viewBox="0 0 24 24" width="50">
                <path d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
            </svg>
        </div>
        <p class="font-bold text-base md:text-center text-sm">
            Se guardó en tus favoritos
        </p>
    @endauth
</div>

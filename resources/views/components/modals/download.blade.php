@props([
    'download' => '0',
    'contentID' => null,
])

@auth

@endauth
<div class="modal_inner flex flex-col items-center justify-center cursor-pointer">
    @auth

        <div class="flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" id='download' enable-background="new 0 0 24 24" height="50"
                viewBox="0 0 24 24" width="50">
                <g>
                    <rect fill="none" height="24" width="24" />
                </g>
                <g>
                    <path
                        d="M18,15v3H6v-3H4v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3H18z M17,11l-1.41-1.41L13,12.17V4h-2v8.17L8.41,9.59L7,11l5,5 L17,11z" />
                </g>
            </svg>
        </div>
        <p class="font-bold text-base md:text-center text-sm">
            Iniciar descarga
        </p>
    @endauth
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
            Necesitamos que te registres para que puedas descargar.
        </p>
    @endguest
</div>
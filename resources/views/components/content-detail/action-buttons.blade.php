@props([
    'share' => '0',
    'buy' => '0',
    'download' => '0',
    'fav' => '0',
    'mail' => '0',
    'downloadable' => $downloadable
])


<div class="col-span-2">
    <div class="iconContainer cursor-pointer lg:border_gris border_1px rounded-lg p-2">
        <svg class='h-8 w-8 md:h-10 md:h-10' id='svg-1' xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path class="inner"
                d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z"
                fill='#d5e5e3' />
        </svg>
    </div>
</div>


<div x-data="{ open: false }" @click.away="open = false" @close.stop="open = false" class="col-span-2">
    <div class="iconContainer cursor-pointer lg:border_gris border_1px rounded-lg p-2" id="buyButton"
        @click="open = ! open">
        <svg class='h-8 w-8 md:h-10 md:h-10' id='svg-2' xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path class="inner"
                d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"
                fill='#d5e5e3' />
        </svg>
    </div>
    <x-modals.main fav={{ $fav }} />
</div>

<div x-data="{ open: false }" @click.away="open = false" @close.stop="open = false" class="col-span-2">
    <div class="iconContainer cursor-pointer lg:border_gris border_1px rounded-lg p-2" id="downloadButton"
        @click="open = ! open">
        <svg class='h-8 w-8 md:h-10 md:h-10' id='svg-3' xmlns="http://www.w3.org/2000/svg"
            enable-background="new 0 0 24 24" viewBox="0 0 24 24">
            <g>
                <rect fill="none" />
            </g>
            <g>
                <path class="inner"
                    d="M18,15v3H6v-3H4v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3H18z M17,11l-1.41-1.41L13,12.17V4h-2v8.17L8.41,9.59L7,11l5,5 L17,11z"
                    fill='#d5e5e3' />
            </g>
        </svg>
    </div>
    <x-modals.main download={{ $download }} :downloadable="$downloadable"/>
</div>

<div x-data="{ open: false }" @click.away="open = false" @close.stop="open = false" class="col-span-2">
    <div class="iconContainer cursor-pointer lg:border_gris border_1px rounded-lg p-2" id="favButton"
        @click="open = ! open">
        <svg class='h-8 w-8 md:h-10 md:h-10' id='svg-4' xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path class="inner"
                d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-1.45-5c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6z"
                fill='#d5e5e3' />
        </svg>
    </div>
    <x-modals.main buy={{ $buy }} />
</div>

<div x-data="{ open: false }" @click.away="open = false" @close.stop="open = false" class="col-span-2">
    <div class="iconContainer cursor-pointer lg:border_gris border_1px rounded-lg p-2" id="mailButton"
        @click="open = ! open">
        <svg class='h-8 w-8 md:h-10 md:h-10' id='svg-5' xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path d="M0 0h24v24H0V0z" fill="none" />
            <path class="inner"
                d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92c0-1.61-1.31-2.92-2.92-2.92zM18 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM6 13c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm12 7.02c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"
                fill='#d5e5e3' />
        </svg>
    </div>
    <x-modals.main share={{ $share }} />
</div>

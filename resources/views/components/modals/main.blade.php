@props([
    'loginMessage' => null,
    'share' => '0',
    'buy' => '0',
    'download' => '0',
    'fav' => '0',
    'contentID' => null,
    'contentID' => null,
    'register' => null,
])

<div x-show="open" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    class="flex items-center justify-center fixed left-0 bottom-0 w-full h-full" style="display: none;">
    <div class="rounded-md shadow-lg bg-white color_azuloscuro modal_container flex justify-center items-center" @click.away="open = false">
        @if ($share == "1")
        <x-modals.share contentID={{$contentID}}/>
        @endif
        @if ($fav == "1")
        <x-modals.fav contentID={{$contentID}}/>       
        @endif
        @if ($download == "1")
        <x-modals.download contentID={{$contentID}}/>           
        @endif
        @if ($buy == "1")
        <x-modals.buy contentID={{$contentID}}/>       
        @endif
        @if ($loginMessage != null)
        <x-modals.welcomeLogin loginMessage={{$loginMessage}}/>         
        @endif
        @if ($register != null)
        <x-modals.register register={{$register}}/>         
        @endif
    </div>
</div>

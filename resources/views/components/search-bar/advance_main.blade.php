<div x-data="{ open: false }" @keydown.window.escape="open = false;$dispatch('overflow')" x-show="open" id="advance_search_modal" style="display: none;"
    class="fixed z-50 inset-0 overflow-y-auto sm:overflow-hidden text-responsive h-screen" aria-labelledby="modal-title" x-ref="dialog" aria-modal="true">
    <div class="block items-end justify-center text-center sm:block sm:p-0 h-screen">

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            x-description="Background overlay, show/hide based on modal state."
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity h-screen" aria-hidden="true" @click="open = false;$dispatch('overflow')">
        </div>

        
        
        
          <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-center sm:h-screen" aria-hidden="true">&ZeroWidthSpace;</span>

        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-description="Modal panel, show/hide based on modal state."
            class="inline-block advance_search_container bg-white rounded-md shadow-xl transform transition-all">
            <x-search-bar.options/>
        </div>

    </div>
</div>

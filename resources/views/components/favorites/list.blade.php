@props([
    'productList' => [],
])

@foreach ($productList as $item)
    <div class="background_grisclaro p-2 rounded-lg mb-4 xl:mx-0 md:mx-5 mx-0">
        <div class="background_grisclaro p-2 rounded-lg border border-dashed border-gray-600">
            <div class="flex items-center justify-start">
                <img src="{{ asset('img/content/2.jpg') }}" alt=""
                    class="zoomContent rounded-lg cursor-pointer h-16 2xl:h-16 xl:h-16 mr-4">
                <div>
                    <p class="color_azuloscuro text_responsive font-bold title_favorite">
                        {{ $item->name }}
                    </p>
                    <div class="flex flex-wrap details_favorite">
                        <p class="color_azuloscuro text_responsive">
                            {{ $item->editorial . ', ' }}
                        </p>
                        <p class="color_azuloscuro text_responsive mr-1">
                            {{ $item->pubYear . ', ' }}
                        </p>
                        <p class="color_azuloscuro text_responsive mr-1">
                            {{ $item->pubLoc . ', ' }}
                        </p>
                        <p class="color_azuloscuro text_responsive mr-1">
                            {{ $item->pubCountry . ', ' }}
                        </p>
                        <p class="color_azuloscuro text_responsive mr-1">
                            {{ $item->lang . ', ' }}
                        </p>
                        <p class="color_azuloscuro text_responsive mr-1">
                            {{ $item->isbn . ', ' }}
                        </p>
                        <p class="color_azuloscuro text_responsive">
                            {{ $item->format . '.' }}
                        </p>
                    </div>
                </div>
                <div
                    class="right-8 md:right-20 lg:right-28 xl:right-28 mt-24 md:mt-20 absolute border-gray-600 background_grisoscuro rounded-md border  flex items-center justify-center hover:bg-gray-800 cursor-pointer ">
                    <i class="fas fa-times text-white text-md p-1 px-2 open_close_modalDelete" id="{{ $item->id}}" product_name="{{ $item->name }}"></i>
                </div>
            </div>

        </div>
    </div>
@endforeach

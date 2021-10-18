<div class="flex flex-col justify-center color_grisclaro text-sm col-span-12 text_responsive_results">
    <div class="flex justify-between items-center w-full">
        <x-max-results.title :search="$search" :contents="$contents"/>
        <x-max-results.orderby/>
    </div>
    <div class="flex flex-wrap justify-left items-center w-full mt-4">
        <x-max-results.tags :types_content="$typesContent"/>
    </div>
    <div class="flex justify-center items-center w-full mt-4">
        <x-max-results.contents_results :contents="$contents"/>
    </div>
</div>

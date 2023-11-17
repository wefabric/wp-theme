@php
    if(! isset($postId)) {
        $postId = $item; //in case of slider, or news page
    }
    $fields = get_fields($postId);
    $service = get_post($postId);

    $categories = get_the_category($postId);

    // Blokinstellingen
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

{{--<div onclick="window.location.href = '{{ get_permalink($postId) }}'" class="cursor-pointer card hover:shadow-3xl max-w-md {{ (isset($lg_hidden) && $lg_hidden) ? 'hidden lg:flex' : 'flex' }} flex-col mx-auto h-full relative ">--}}
{{--    <div class="mx-auto mb-5 w-full rounded-lg">--}}
{{--        @include('components.image', [--}}
{{--            'image_id' => get_post_thumbnail_id($postId),--}}
{{--			'size' => 'news-thumbnail',--}}
{{--			'class' => 'disable-rounded',--}}
{{--            'img_class' => 'rounded-t-lg w-full max-h-[200px]',--}}
{{--        ])--}}
{{--    </div>--}}

{{--    <div class="px-7">--}}
{{--        <div class="card-category-title leading-relaxed">--}}
{{--            {{ $categories[0]->name }}--}}
{{--        </div>--}}

{{--        <div class="">--}}
{{--            @include('components.headings.normal', [--}}
{{--                'type' => 'h3',--}}
{{--				'display' => 'h4',--}}
{{--                'heading' => get_the_title($postId),--}}
{{--            ])--}}
{{--        </div>--}}

{{--        <div class="pb-16">--}}
{{--            @include('components.content', [--}}
{{--                'content' => get_the_excerpt($postId),--}}
{{--            ])--}}
{{--        </div>--}}

{{--        <div class="absolute bottom-0 right-5 w-full pb-5">--}}
{{--            <div class="text-right text-base text-bold">--}}
{{--                @include('components.link.opening', [--}}
{{--                    'href' => get_permalink($postId),--}}
{{--                    'alt' => 'Lees meer',--}}
{{--                    'class' => 'no-underline group',--}}
{{--                ])--}}
{{--					<span class="group-hover:underline">Lees meer</span>--}}
{{--					<i class="fa-solid fa-circle-caret-right ml-2"></i>--}}
{{--                @include('components.link.closing')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


{{--@php--}}
{{--    $fields = get_fields($post);--}}
{{--    $postThumbnailId = get_post_thumbnail_id($post);--}}
{{--    $postTitle = get_the_title($post);--}}
{{--    $postUrl = get_permalink($post);--}}

{{--    // Weergave--}}
{{--    $visibleElements = $block['data']['show_element'] ?? [];--}}
{{--    $postSummary = get_the_excerpt($post);--}}
{{--    $postDate = get_the_date('j F, Y', $post);--}}
{{--    $postAuthorId = get_post_field('post_author', $post);--}}
{{--    $postAuthorName = get_the_author_meta('display_name', $postAuthorId);--}}
{{--    $postCategories = get_the_category($post);--}}
{{--@endphp--}}


<div class="nieuws-item group h-full">
    <div class="h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
            <a href="{{ get_permalink($postId) }}"
               class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
            {{--                @if (!empty($visibleElements) && in_array('category', $visibleElements))--}}
            {{--                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">--}}
            {{--                        @foreach ($postCategories as $category)--}}
            {{--                            <a href="{{ $category->slug }}" class="bg-secondary px-4 py-2 rounded-full text-black">--}}
            {{--                                {{ $category->name }}--}}
            {{--                            </a>--}}
            {{--                        @endforeach--}}
            {{--                    </div>--}}
            {{--                @endif--}}
            @include('components.image', [
                'image_id' => get_post_thumbnail_id($postId),
                'size' => 'news-thumbnail',
                'object_fit' => 'cover',
                'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                'alt' => get_the_title($postId),
        ])
        </div>

        <div class="w-full mt-5">
            {{--            @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($postDate))--}}
            {{--                <p class="text-gray-500">{{ $postDate }}</p>--}}
            {{--            @endif--}}

            <a href="{{ get_permalink($postId) }}"
               class="font-bold text-lg group-hover:text-primary">{{ get_the_title($postId) }}</a>
            <div class="news-info">
                <p class="mt-3 mb-2">{{ get_the_excerpt($postId) }} </p>
                {{--                @if (!empty($visibleElements) && in_array('author', $visibleElements) && !empty($postAuthorName))--}}
                {{--                    <p class="text-gray-500">Geschreven door {{ $postAuthorName }}</p>--}}
                {{--                @endif--}}
                <div class="mt-4 md:mt-8 z-10">
                    @include('components.buttons.default', [
                       'text' => 'Lees meer',
                       'href' => get_permalink($postId),
                       'alt' => 'Lees meer',
                       'colors' => 'btn-primary-color btn-filled',
                       'class' => 'rounded-lg',
                   ])
                </div>
            </div>
        </div>
    </div>
</div>
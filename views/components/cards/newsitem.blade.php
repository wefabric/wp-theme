@php
    if(! isset($postId)) {
        $postId = $item; //in case of slider, or news page
    }

    $fields = get_fields($postId);
    $service = get_post($postId);

    $postCategories = get_the_category($postId);

    $postSummary = get_the_excerpt($postId);
        $maxSummaryLength = 180;
        if (strlen($postSummary) > $maxSummaryLength) {
            $postSummary = substr($postSummary, 0, $maxSummaryLength - 3) . '...';
        }

    // Blokinstellingen
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<div class="nieuws-item group h-full">
    <div class="h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
            <a href="{{ get_permalink($postId) }}"
               class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>


            <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                @if($postCategories)
                    @foreach ($postCategories as $category)
                        @php
                            $categoryColor = get_field('category_color', $category);
                        @endphp
                        <div style="background-color: {{ $categoryColor }}"
                             class="@if(empty($categoryColor)) bg-primary hover:bg-primary-dark @endif text-white px-4 py-2 rounded-full">
                            {!! $category->name !!}
                        </div>
                    @endforeach
                @endif
            </div>

            @include('components.image', [
                'image_id' => get_post_thumbnail_id($postId),
                'size' => 'news-thumbnail',
                'object_fit' => 'cover',
                'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                'alt' => get_the_title($postId),
        ])
        </div>

        <div class="flex flex-col w-full grow mt-5">

            <a href="{{ get_permalink($postId) }}"
               class="font-bold text-lg group-hover:text-primary">{!! get_the_title($postId) !!}</a>

            <div class="news-info">
                <p class="mt-3 mb-2">{!! $postSummary !!}</p>
            </div>

            <div class="mt-auto pt-8 z-10">
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
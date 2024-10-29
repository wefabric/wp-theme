@php
    $fields = get_fields($story);
    $storyThumbnailID = get_post_thumbnail_id($story);
    $storyTitle = get_the_title($story);
    $storyUrl = get_permalink($story);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $storySummary = get_the_excerpt($story) ?? '';
    $storyCategories = get_the_terms($story, 'verhaal_categories');
@endphp

<div class="story-item group h-full">
    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($storyThumbnailID)
            <div class="image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $storyUrl }}" aria-label="Ga naar {{ $storyTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($storyCategories && !is_bool($storyCategories))
                        <div class="story-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($storyCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="story-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full">
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>

                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $storyThumbnailID,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $storyTitle,
                ])
            </div>
        @endif
        <div class="story-content flex flex-col w-full grow mt-5">

            <a href="{{ $storyUrl }}" aria-label="Ga naar {{ $storyTitle }} pagina" class="story-title-text font-bold text-{{ $storyTitleColor }} text-lg group-hover:text-primary">{!! $storyTitle !!}</a>

            <div class="story-data mt-4 text-{{ $storyTextColor }}">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($storySummary))
                    <p class="mt-3 mb-3">{{ $storySummary }}</p>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $storyUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                       ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
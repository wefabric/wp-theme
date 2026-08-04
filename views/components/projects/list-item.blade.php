@php
    $projectThumbnailId = get_post_thumbnail_id($project);
    $projectTitle = get_the_title($project);
    $projectSummary = get_the_excerpt($project);
    $projectUrl = get_permalink($project);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $projectCategories = get_the_terms($project, 'project_categories');

    // Afbeeldingen (uitgelichte afbeelding + extra afbeeldingen voor de swiper)
    $showImageSwiper = !empty($visibleElements) && in_array('image_slider', $visibleElements);
    $projectGalleryRows = get_field('project_images', $project) ?: [];
    $projectGalleryImageIds = array_values(array_filter(array_map(fn ($row) => $row['image'] ?? null, $projectGalleryRows)));
    $projectImageIds = $projectThumbnailId ? array_merge([$projectThumbnailId], $projectGalleryImageIds) : $projectGalleryImageIds;
    $projectImageIds = array_values(array_unique($projectImageIds));
    $hasMultipleProjectImages = $showImageSwiper && count($projectImageIds) > 1;
    $projectImageSwiperClass = 'project-image-swiper-' . $project . '-' . mt_rand(0, 999999);
@endphp

<div class="project-item group h-full @if ($flyinEffect) project-hidden @endif">
    <div class="project-wrapper h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if (!empty($projectImageIds))
            <div class="project-image image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                @if ($hasMultipleProjectImages)
                    <div class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out pointer-events-none"></div>
                @else
                    <a href="{{ $projectUrl }}" aria-label="Ga naar {{ $projectTitle }} pagina"
                       class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out">
                        <span class="sr-only">Ga naar {{ $projectTitle }} pagina</span>
                    </a>
                @endif
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($projectCategories && !is_bool($projectCategories))
                        <div class="project-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($projectCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                    $categoryImage = get_field('category_image', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="project-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    @if($categoryImage)
                                        <img src="{{ wp_get_attachment_image_url($categoryImage, 'thumbnail') }}" alt="{{ $category->name }}" class="w-5 h-5 object-contain">
                                    @endif
                                    {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @if ($hasMultipleProjectImages)
                    <div class="project-image-swiper swiper {{ $projectImageSwiperClass }} h-full w-full">
                        <div class="swiper-wrapper h-full">
                            @foreach ($projectImageIds as $projectImageId)
                                <div class="swiper-slide h-full">
                                    <a href="{{ $projectUrl }}" aria-label="Ga naar {{ $projectTitle }} pagina" class="block h-full w-full">
                                        @include('components.image', [
                                           'image_id' => $projectImageId,
                                           'size' => 'full',
                                           'object_fit' => 'cover',
                                           'img_class' => 'aspect-square w-full h-full object-cover object-center',
                                           'alt' => $projectTitle,
                                        ])
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="project-image-nav">
                        <div role="button" tabindex="0" aria-label="Vorige foto" class="swiper-button-prev project-image-button-prev-{{ $projectImageSwiperClass }}"></div>
                        <div role="button" tabindex="0" aria-label="Volgende foto" class="swiper-button-next project-image-button-next-{{ $projectImageSwiperClass }}"></div>
                    </div>
                    <script>
                        window.addEventListener('DOMContentLoaded', () => {
                            new Swiper('.{{ $projectImageSwiperClass }}', {
                                nested: true,
                                preventClicks: true,
                                preventClicksPropagation: true,
                                navigation: {
                                    nextEl: '.project-image-button-next-{{ $projectImageSwiperClass }}',
                                    prevEl: '.project-image-button-prev-{{ $projectImageSwiperClass }}',
                                },
                            });
                        });
                    </script>
                @else
                    @include('components.image', [
                       'image_id' => $projectImageIds[0],
                       'size' => 'full',
                       'object_fit' => 'cover',
                       'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                       'alt' => $projectTitle,
                    ])
                @endif
            </div>
        @endif
        <div class="project-content flex flex-col w-full grow mt-5">

            <a href="{{ $projectUrl }}" aria-label="Ga naar {{ $projectTitle }} pagina" class="project-title-text font-bold text-{{ $projectTitleColor }} text-lg group-hover:text-primary">{!! $projectTitle !!}</a>

            <div class="project-data text-{{ $projectTextColor }}">

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($projectSummary))
                    <div class="project-summary mt-3 mb-3">{!! $projectSummary !!}</div>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="project-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $projectUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                           'icon' => $buttonCardIcon,
                        ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
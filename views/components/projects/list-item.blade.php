@php
    $projectThumbnailId = get_post_thumbnail_id($project);
    $projectTitle = get_the_title($project);
    $projectSummary = get_the_excerpt($project);
    $projectUrl = get_permalink($project);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $projectCategories = get_the_terms($project, 'project_categories');
@endphp

<div class="project-item group h-full @if ($flyinEffect) project-hidden @endif">
    <div class="h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if ($projectThumbnailId)
            <div class="image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $projectUrl }}" aria-label="Ga naar {{ $projectTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($projectCategories && !is_bool($projectCategories))
                        <div class="project-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($projectCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="project-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $projectThumbnailId,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $projectTitle,
                ])
            </div>
        @endif
        <div class="project-content flex flex-col w-full grow mt-5">

            <a href="{{ $projectUrl }}" aria-label="Ga naar {{ $projectTitle }} pagina" class="project-title-text font-bold text-{{ $projectTitleColor }} text-lg group-hover:text-primary">{!! $projectTitle !!}</a>

            <div class="project-data text-{{ $projectTextColor }}">

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($projectSummary))
                    <p class="mt-3 mb-3">{{ $projectSummary }}</p>
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
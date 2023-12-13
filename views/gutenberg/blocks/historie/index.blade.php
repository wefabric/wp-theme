@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    $timelineLineColor = $block['data']['timeline_line_color'] ?? '';
    $timelineYearTextColor = $block['data']['timeline_year_text_color'] ?? '';
    $timelineTextColor = $block['data']['timeline_text_color'] ?? '';
    $timelineBlockBackgroundColor = $block['data']['timeline_block_background_color'] ?? '';

    // Show timeline items
    $timelineData = [];
    $numTimelineItems = intval($block['data']['timeline']);

    for ($i = 0; $i < $numTimelineItems; $i++) {
        $imageKey = "timeline_{$i}_image";
        $yearKey = "timeline_{$i}_year";
        $textKey = "timeline_{$i}_text";

        $imageID = $block['data'][$imageKey] ?? '';
        $year = $block['data'][$yearKey] ?? '';
        $text = $block['data'][$textKey] ?? '';

        $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);

        $timelineData[] = [
            'imageId' => $imageID,
            'year' => $year,
            'text' => $text,
            'alt' => $imageAlt,
        ];
    }

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="historie" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="lg:mb-4 text-{{ $titleColor }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
            @endif

            <div class="mt-8 lg:mt-16 relative h-full">
                <div class="w-[4px] bg-{{ $timelineLineColor }} h-full absolute lg:left-1/2 -translate-x-1/2">
                    <div class="w-[12px] h-[12px] bg-{{ $timelineLineColor }} rounded-full absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 "></div>
                    <div class="w-[12px] h-[12px] bg-{{ $timelineLineColor }} rounded-full absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 "></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2">
                    @foreach ($timelineData as $index => $item)
                        @php
                            $isOdd = $index % 2 !== 0;
                            $cardClass = $isOdd ? 'right-card' : 'left-card';
                            $marginLeftClass = $isOdd ? 'lg:pl-16 mt-8 lg:mt-20' : 'lg:pl-0 lg:pr-16 mt-8 lg:mt-0';
                            $timelineLinePosition = $isOdd ? 'top-1/2' : 'lg:left-auto lg:right-0 top-1/2';
                            $roundedFullPosition = $isOdd ? 'right-0 top-1/2 translate-x-1/2 -translate-y-1/2' : 'left-auto right-0 lg:right-auto lg:left-0 top-1/2 translate-x-1/2 lg:-translate-x-1/2 -translate-y-1/2';
                        @endphp

                        <div class="{{ $cardClass }} timeline-card relative h-fit pl-10 {{ $marginLeftClass }}">
                            <div class="w-[20px] lg:w-[30px] h-[4px] bg-{{ $timelineLineColor }} absolute left-0 {{ $timelineLinePosition }}">
                                <div class="w-[12px] h-[12px] bg-{{ $timelineLineColor }} rounded-full absolute {{ $roundedFullPosition }}"></div>
                            </div>
                            @if($item['imageId'])
                                <div class="relative h-[170px]">
                                    @include('components.image', [
                                        'image_id' => $item['imageId'],
                                        'size' => 'full',
                                        'object_fit' => 'cover',
                                        'img_class' => 'h-[170px] w-full',
                                        'alt' => $item['alt']
                                    ])
                                </div>
                            @endif
                            <div class="relative p-4 lg:p-8 bg-{{ $timelineBlockBackgroundColor }}">
                                @if($item['year'])
                                    <p class="h3 text-{{ $timelineYearTextColor }}">{{ $item['year'] }}</p>
                                @endif
                                @if($item['text'])
                                    @include('components.content', ['content' => apply_filters('the_content', $item['text']), 'class' => 'text-' . $timelineTextColor])
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
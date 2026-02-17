@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $subtitleIcon = $block['data']['subtitle_icon'] ?? '';
    $subtitleIcon = $subtitleIcon ? json_decode($subtitleIcon, true) : null;
    $subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';
        $button1Download = $block['data']['button_button_1_download'] ?? false;
        $button1Icon = $block['data']['button_button_1_icon'] ?? '';
        if (!empty($button1Icon)) {
            $iconData = json_decode($button1Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button1Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }
        $button2Text = $block['data']['button_button_2']['title'] ?? '';
        $button2Link = $block['data']['button_button_2']['url'] ?? '';
        $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
        $button2Color = $block['data']['button_button_2_color'] ?? '';
        $button2Style = $block['data']['button_button_2_style'] ?? '';
        $button2Download = $block['data']['button_button_2_download'] ?? false;
        $button2Icon = $block['data']['button_button_2_icon'] ?? '';
        if (!empty($button2Icon)) {
            $iconData = json_decode($button2Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button2Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

        $buttonCardText = $block['data']['card_button_button_text'] ?? '';
        $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
        $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';
        $buttonCardIcon = $block['data']['card_button_button_icon'] ?? '';
        if (!empty($buttonCardIcon)) {
            $iconData = json_decode($buttonCardIcon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $buttonCardIcon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

        $textPosition = $block['data']['text_position'] ?? '';
        $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $textClassMap[$textPosition] ?? '';


    // Planning
    $planningDisplay = $block['data']['planning_display'] ?? 'percentage';
    $planningMarkers = [];
    $numMarkers = intval($block['data']['planning_marker'] ?? 0);
    $markersTemp = [];

    for ($i = 0; $i < $numMarkers; $i++) {
        $titleKey = "planning_marker_{$i}_marker_title";
        $textKey = "planning_marker_{$i}_marker_text";
        $percentageKey = "planning_marker_{$i}_marker_percentage";
        $dateKey = "planning_marker_{$i}_marker_date";

        $markerTitle = $block['data'][$titleKey] ?? '';
        $markerText = $block['data'][$textKey] ?? '';
        $markerPercentage = $block['data'][$percentageKey] ?? 0;
        $markerDate = $block['data'][$dateKey] ?? null;

        $markersTemp[] = [
            'marker_title' => $markerTitle,
            'marker_text' => $markerText,
            'marker_percentage' => $markerPercentage,
            'marker_date' => $markerDate ? strtotime($markerDate) : null,
        ];
    }

    if ($planningDisplay === 'date') {
        $dates = array_filter(array_column($markersTemp, 'marker_date'));
        if (!empty($dates)) {
            $minDate = min($dates);
            $maxDate = max($dates);
            $totalDiff = $maxDate - $minDate ?: 1;

            foreach ($markersTemp as $index => $marker) {
                if ($index === 0) {
                    $marker['marker_percentage'] = 0;
                } elseif ($index === $numMarkers - 1) {
                    $marker['marker_percentage'] = 100;
                } elseif ($marker['marker_date']) {
                    $marker['marker_percentage'] = round((($marker['marker_date'] - $minDate) / $totalDiff) * 100, 2);
                } else {
                    $marker['marker_percentage'] = 0;
                }

                $planningMarkers[] = $marker;
            }
        } else {
            $planningMarkers = $markersTemp;
        }
    } else {
        $planningMarkers = $markersTemp;
    }


    $currentPercentage = $block['data']['current_percentage'] ?? 0;

    if ($planningDisplay === 'date' && !empty($planningMarkers)) {
        $today = time();
        $dates = array_column($planningMarkers, 'marker_date');
        $dates = array_filter($dates); // remove nulls

        if (!empty($dates)) {
            $minDate = min($dates);
            $maxDate = max($dates);
            $totalDiff = $maxDate - $minDate ?: 1;

            $currentPercentage = round((($today - $minDate) / $totalDiff) * 100, 2);

            $currentPercentage = max(0, min(100, $currentPercentage));
        } else {
            $currentPercentage = 0;
        }
    }

    $markerTitleColor = $block['data']['marker_title_color'] ?? '';
    $markerTextColor = $block['data']['marker_text_color'] ?? '';
    $progressionBarColor = $block['data']['progression_bar_color'] ?? '';
    $progressionBarBackgroundColor = $block['data']['progression_bar_background_color'] ?? '';
    $currentProgressIndicationColor = $block['data']['current_progress_indication_color'] ?? '';




    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';


    // Paddings & margins
    \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter;

    $mobilePaddingTop = $block['data']['padding_mobile_padding_top'] ?? '';
    $mobilePaddingRight = $block['data']['padding_mobile_padding_right'] ?? '';
    $mobilePaddingBottom = $block['data']['padding_mobile_padding_bottom'] ?? '';
    $mobilePaddingLeft = $block['data']['padding_mobile_padding_left'] ?? '';
    $tabletPaddingTop = $block['data']['padding_tablet_padding_top'] ?? '';
    $tabletPaddingRight = $block['data']['padding_tablet_padding_right'] ?? '';
    $tabletPaddingBottom = $block['data']['padding_tablet_padding_bottom'] ?? '';
    $tabletPaddingLeft = $block['data']['padding_tablet_padding_left'] ?? '';
    $desktopPaddingTop = $block['data']['padding_desktop_padding_top'] ?? '';
    $desktopPaddingRight = $block['data']['padding_desktop_padding_right'] ?? '';
    $desktopPaddingBottom = $block['data']['padding_desktop_padding_bottom'] ?? '';
    $desktopPaddingLeft = $block['data']['padding_desktop_padding_left'] ?? '';

    $mobileMarginTop = $block['data']['margin_mobile_margin_top'] ?? '';
    $mobileMarginRight = $block['data']['margin_mobile_margin_right'] ?? '';
    $mobileMarginBottom = $block['data']['margin_mobile_margin_bottom'] ?? '';
    $mobileMarginLeft = $block['data']['margin_mobile_margin_left'] ?? '';
    $tabletMarginTop = $block['data']['margin_tablet_margin_top'] ?? '';
    $tabletMarginRight = $block['data']['margin_tablet_margin_right'] ?? '';
    $tabletMarginBottom = $block['data']['margin_tablet_margin_bottom'] ?? '';
    $tabletMarginLeft = $block['data']['margin_tablet_margin_left'] ?? '';
    $desktopMarginTop = $block['data']['margin_desktop_margin_top'] ?? '';
    $desktopMarginRight = $block['data']['margin_desktop_margin_right'] ?? '';
    $desktopMarginBottom = $block['data']['margin_desktop_margin_bottom'] ?? '';
    $desktopMarginLeft = $block['data']['margin_desktop_margin_left'] ?? '';


    // Animaties
    $flyinEffect = $block['data']['flyin_effect'] ?? false;
    $animateProgressBar = $block['data']['animate_progress_bar'] ?? false;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'planning' }}@endif" class="block-planning relative planning-{{ $randomNumber }}-custom-padding planning-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} {{ $textClass }}">
                    @if ($subtitleIcon)
                        <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                    @endif
                    {!! $subTitle !!}
                </span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} {{ $textClass }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ' ' .  $textClass . ($blockWidth == 'fullscreen' ? ' ' : '')
                ])
            @endif

            <div class="grid grid-cols-1 md:grid-cols-12 py-24">
                <div class="col-span-full md:col-start-2 md:col-span-10 flex gap-2 md:block" id="timeline-container">

                    <div class="timeline-background relative w-7 md:w-full h-[30rem] md:h-7 bg-{{ $progressionBarBackgroundColor }}">
                        <div id="timeline-progress" class="absolute inset-0 bg-{{ $progressionBarColor }} timeline-progress"
                             data-percentage="{{ $currentPercentage }}">
                            <div class="absolute bottom-0 md:bottom-[100%] left-[100%] md:left-auto md:right-0 w-[26px] md:w-px h-px md:h-[20px] bg-{{ $currentProgressIndicationColor }}"></div>
                            <div class="z-10 absolute left-full md:left-auto bottom-0 md:bottom-full md:right-0 translate-x-5 md:translate-x-1/2 translate-y-1/2 md:-translate-y-5">
                                <div class="current-indicator-text bg-{{ $currentProgressIndicationColor }} text-white p-2 leading-none font-medium">Nu</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative w-full md:mt-4">
                        @foreach ($planningMarkers as $marker)
                            @php
                                $markerPercentage = $marker['marker_percentage'];
                                $markerTitle = $marker['marker_title'];
                                $markerText = $marker['marker_text'];
                            @endphp
                            <div class=" timeline-marker -translate-y-1/2 md:translate-y-0 md:-translate-x-1/2 absolute md:top-0 flex items-center gap-4 md:flex-col md:text-center w-full md:w-[120px]" data-percentage="{{ $markerPercentage }}">
                                <div class="marker-indicator w-0 h-0 border-y-[6px] border-y-transparent border-r-[10px] border-r-{{ $currentProgressIndicationColor }} md:rotate-90"></div>
                                <div class="planning-item @if ($flyinEffect) planning-hidden @endif">
                                    <div class="marker-title font-bold text-{{ $markerTitleColor }}">{!! $markerTitle !!}</div>
                                    <div class="marker-text text-{{ $markerTextColor }}">{!! $markerText !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if (($button1Text) && ($button1Link))
                <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">
                    @include('components.buttons.default', [
                        'text' => $button1Text,
                        'href' => $button1Link,
                        'alt' => $button1Text,
                        'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                        'class' => 'rounded-lg',
                        'target' => $button1Target,
                        'icon' => $button1Icon,
                        'download' => $button1Download,
                    ])
                    @if (($button2Text) && ($button2Link))
                        @include('components.buttons.default', [
                            'text' => $button2Text,
                            'href' => $button2Link,
                            'alt' => $button2Text,
                            'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                            'class' => 'rounded-lg',
                            'target' => $button2Target,
                            'icon' => $button2Icon,
                            'download' => $button2Download,
                        ])
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .planning-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($mobilePaddingTop) padding-top: {{ $mobilePaddingTop }}px; @endif
            @if($mobilePaddingRight) padding-right: {{ $mobilePaddingRight }}px; @endif
            @if($mobilePaddingBottom) padding-bottom: {{ $mobilePaddingBottom }}px; @endif
            @if($mobilePaddingLeft) padding-left: {{ $mobilePaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletPaddingTop) padding-top: {{ $tabletPaddingTop }}px; @endif
            @if($tabletPaddingRight) padding-right: {{ $tabletPaddingRight }}px; @endif
            @if($tabletPaddingBottom) padding-bottom: {{ $tabletPaddingBottom }}px; @endif
            @if($tabletPaddingLeft) padding-left: {{ $tabletPaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopPaddingTop) padding-top: {{ $desktopPaddingTop }}px; @endif
            @if($desktopPaddingRight) padding-right: {{ $desktopPaddingRight }}px; @endif
            @if($desktopPaddingBottom) padding-bottom: {{ $desktopPaddingBottom }}px; @endif
            @if($desktopPaddingLeft) padding-left: {{ $desktopPaddingLeft }}px; @endif
        }
    }

    .planning-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($mobileMarginTop) margin-top: {{ $mobileMarginTop }}px; @endif
            @if($mobileMarginRight) margin-right: {{ $mobileMarginRight }}px; @endif
            @if($mobileMarginBottom) margin-bottom: {{ $mobileMarginBottom }}px; @endif
            @if($mobileMarginLeft) margin-left: {{ $mobileMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletMarginTop) margin-top: {{ $tabletMarginTop }}px; @endif
            @if($tabletMarginRight) margin-right: {{ $tabletMarginRight }}px; @endif
            @if($tabletMarginBottom) margin-bottom: {{ $tabletMarginBottom }}px; @endif
            @if($tabletMarginLeft) margin-left: {{ $tabletMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopMarginTop) margin-top: {{ $desktopMarginTop }}px; @endif
            @if($desktopMarginRight) margin-right: {{ $desktopMarginRight }}px; @endif
            @if($desktopMarginBottom) margin-bottom: {{ $desktopMarginBottom }}px; @endif
            @if($desktopMarginLeft) margin-left: {{ $desktopMarginLeft }}px; @endif
        }
    }

    .planning-hidden {
        opacity: 0;
    }

    .planning-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.timeline-progress');

        function updateTimelineMarkers() {
            const isMobile = window.innerWidth < 768;

            document.querySelectorAll('.timeline-marker').forEach(function(element) {
                const percentage = element.getAttribute('data-percentage');
                if (isMobile) {
                    element.style.top = percentage + '%';
                    element.style.left = '2rem';
                } else {
                    element.style.left = percentage + '%';
                    element.style.top = '';
                }
            });
        }

        updateTimelineMarkers();

        window.addEventListener('resize', () => {
            const isMobile = window.innerWidth < 768;

            progressBars.forEach(progressBar => {
                const percentage = parseFloat(progressBar.dataset.percentage);

                progressBar.style.transition = 'none';

                if (isMobile) {
                    progressBar.style.width = '';
                    progressBar.style.height = percentage + '%';
                } else {
                    progressBar.style.height = '';
                    progressBar.style.width = percentage + '%';
                }
            });

            updateTimelineMarkers();
        });

        @if($animateProgressBar)
        progressBars.forEach(function(progressBar) {
            const percentage = parseFloat(progressBar.dataset.percentage);

            if (window.innerWidth < 768) {
                progressBar.style.height = '0';
            } else {
                progressBar.style.width = '0';
            }

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        progressBar.style.transition = 'width 1s ease, height 1s ease';
                        if (window.innerWidth < 768) {
                            progressBar.style.height = percentage + '%';
                        } else {
                            progressBar.style.width = percentage + '%';
                        }
                        obs.unobserve(progressBar);
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(progressBar);
        });
        @else
        progressBars.forEach(function(progressBar) {
            const percentage = parseFloat(progressBar.dataset.percentage);

            if (window.innerWidth < 768) {
                progressBar.style.height = percentage + '%';
                progressBar.style.width = '';
            } else {
                progressBar.style.width = percentage + '%';
                progressBar.style.height = '';
            }
        });
        @endif
    });
</script>


@if ($flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const planningItems = document.querySelectorAll('.planning-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const planningItem = entry.target;

                        setTimeout(() => {
                            if (planningItem.classList.contains('planning-hidden')) {
                                planningItem.classList.add('planning-animated');
                                planningItem.classList.remove('planning-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(planningItem);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            planningItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endif
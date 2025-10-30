@php
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

    // Nieuws
    $onlyPrimaryCategory = $block['data']['show_primary_category'] ?? false;
    $newsTitleColor = $block['data']['news_title_color'] ?? '';
    $newsTextColor = $block['data']['news_text_color'] ?? '';
    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;

    $displayType = $block['data']['display_type'];

    // Show all
    if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'post',
            'post_status'    => 'publish',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }


        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }

    // Show category
    elseif ($displayType == 'show_category') {
        $selectedCategory = $block['data']['category'] ?? '';
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'post',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $selectedCategory,
                ],
            ],
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }

    // Show specific
    elseif ($displayType == 'show_specific') {
        $posts = $block['data']['show_specific_news'];
        if (!is_array($posts) || empty($posts)) {
            $posts = [];
        }
    }

    // Show random
    elseif ($displayType == 'show_random') {
        $postAmount = $block['data']['post_amount'] ?? 3;
        $args = [
            'posts_per_page' => $postAmount,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'orderby'        => 'rand',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }

    // Show latest
    elseif ($displayType == 'show_latest') {
        $postAmount = $block['data']['post_amount'] ?? 3;
        $args = [
            'posts_per_page' => $postAmount,
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }


    // Animaties
    $hoverEffect = $block['data']['hover_effect'] ?? '';
    $hoverEffectClasses = [
        'lift-up' => 'group-hover:-translate-y-2 group-hover:md:-translate-y-4',
        'scale-up' => 'group-hover:scale-105',
        'scale-down' => 'group-hover:scale-95',
        'none' => ''
    ];
    $hoverEffectClass = $hoverEffectClasses[$hoverEffect] ?? '';

    $flyinEffect = $block['data']['flyin_effect'] ?? false;
@endphp

<x-wefabric:section block-type="nieuws" :block="$block" id="@if($customBlockId){{ $customBlockId }}@else{{ 'nieuws' }}@endif" class="block-nieuws block-{{ $randomNumber }} relative nieuws-{{ $randomNumber }}-custom-padding nieuws-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
                    style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if($swiperOutContainer)
        <div class="overflow-hidden">
    @endif
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
{{--                        <x-wefabric:title :block="$block"></x-wefabric:title>--}}
                        <h2 class="title mb-4 text-{{ $titleColor }} {{ $textClass }}">{!! $title !!}</h2>
                    @endif
                    @if ($text)
                        <x-wefabric:content :content="$text" :class="'mb-8 text-' . $textColor . ($flyInAnimation ? ' flyin-animation' : '')"></x-wefabric:content>
                    @endif
                    @if (!empty($block['data']['show_element']) && in_array('category_filter', $block['data']['show_element']))
                        <div class="categories mt-6">
                            @include('components.news.category-list')
                        </div>
                    @endif
                    @if($posts)
                        @include('components.news.list', ['posts' => $posts])
                    @endif

                    @if ($buttons->count() >= 1)
                        <div class="{{ $textClass }} buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 @if ($flyInAnimation) flyin-animation @endif">
                            @foreach ($buttons as $button)
                                {!! $button->render()->render(); !!}
                            @endforeach
                        </div>
                    @endif

{{--                    @if (($button1Text) && ($button1Link))--}}
{{--                        <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">--}}
{{--                            @include('components.buttons.default', [--}}
{{--                                'text' => $button1Text,--}}
{{--                                'href' => $button1Link,--}}
{{--                                'alt' => $button1Text,--}}
{{--                                'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,--}}
{{--                                'class' => 'rounded-lg',--}}
{{--                                'target' => $button1Target,--}}
{{--                                'icon' => $button1Icon,--}}
{{--                                'download' => $button1Download,--}}
{{--                            ])--}}
{{--                            @if (($button2Text) && ($button2Link))--}}
{{--                                @include('components.buttons.default', [--}}
{{--                                    'text' => $button2Text,--}}
{{--                                    'href' => $button2Link,--}}
{{--                                    'alt' => $button2Text,--}}
{{--                                    'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,--}}
{{--                                    'class' => 'rounded-lg',--}}
{{--                                    'target' => $button2Target,--}}
{{--                                    'icon' => $button2Icon,--}}
{{--                                    'download' => $button2Download,--}}
{{--                                ])--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>
            @if($swiperOutContainer)
        </div>
    @endif
</x-wefabric:section>

<style>
    .nieuws-{{ $randomNumber }}-custom-padding {
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

    .nieuws-{{ $randomNumber }}-custom-margin {
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

    .news-hidden {
        opacity: 0;
    }

    .swiper-slide-duplicate .news-hidden {
        animation: flyIn 0.6s ease-out forwards !important;
    }

    .news-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

@if ($flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const newsItems = document.querySelectorAll('.nieuws-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const newsItem = entry.target;

                        setTimeout(() => {
                            if (newsItem.classList.contains('news-hidden')) {
                                newsItem.classList.add('news-animated');
                                newsItem.classList.remove('news-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(newsItem);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            newsItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endif
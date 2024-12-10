@php
    //    todo: Needs block update

    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Show links
    $linksCount = $block['data']['links'] ?? 0;
    $links = [];

     for ($i = 0; $i < $linksCount; $i++) {

        $linkKey = "links_{$i}_link";
        $linkUrl = $block['data'][$linkKey]['url'] ?? '';
        $linkText = $block['data'][$linkKey]['title'] ?? '';
        $linkTarget = $block['data'][$linkKey]['target'] ?? '';

        $links[] = [
            'text' => $linkText,
            'link' => $linkUrl,
            'target' => $linkTarget,
        ];
    }

    $stickyMenu = $block['data']['sticky_submenu'] ?? true;

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
@endphp

<section id="submenu" class="block-submenu @if($stickyMenu) sticky-submenu sticky z-40 @else relative @endif bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 @if($stickyMenu) py-8 @else py-8 2xl:py-16 @endif {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mb-4 text-' . $textColor])
            @endif
            <div class="flex flex-wrap gap-1 text-{{ $textColor }}">
                @foreach($links as $index => $link)
                    @if ($link['text'] && $link['link'])
                        <a href="{{ $link['link'] }}" class="underline hover:text-primary" target="{{ $link['target'] }}" aria-label="Ga naar {{ $link['text'] }}">{{ $link['text'] }}</a>
                        @if ($index < count($links) - 1)
                            <span class="separator">|</span>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

@if ($stickyMenu)
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            var mastheadHeight = $('#masthead').outerHeight();
            var submenuHeight = $('.sticky-submenu').outerHeight();
            var combinedHeight = mastheadHeight + submenuHeight;
            var submenu = $('.sticky-submenu');

            // Apply scroll-margin to all elements using a style tag
            $('head').append('<style>* { scroll-margin: ' + combinedHeight + 'px !important; }</style>');

            // Initial positioning
            submenu.css('top', mastheadHeight + 'px');

            $(window).scroll(function() {
                // Check if the user has scrolled past the masthead
                if ($(window).scrollTop() > mastheadHeight) {
                    // Add shadow-xl class when scrolled
                    submenu.addClass('shadow-xl');
                } else {
                    // Remove shadow-xl class when not scrolled
                    submenu.removeClass('shadow-xl');
                }
            });
        });
    </script>
@endif
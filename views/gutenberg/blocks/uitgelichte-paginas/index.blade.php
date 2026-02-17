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

        $textPosition = $block['data']['text_position'] ?? '';
        $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $textClassMap[$textPosition] ?? '';


    // Pagina's
    $pagesData = [];
    $numPages = isset($block['data']['pages']) ? intval($block['data']['pages']) : 0;
    $pageTitleColor = $block['data']['page_title_color'] ?? '';
    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;

    $selectedPostType = $block['data']['cardblock_post_type'] ?? '';
    $parentPagesOnly = ($block['data']['parent_pages_only']) ?? false;
    $pageVisual = $block['data']['page_visual'] ?? 'featured_image';

    // Als er een post type is geselecteerd, haal dan alle berichten van deze post type op
    if (!empty($selectedPostType)) {
        $pageVisual = 'featured_image';
        $args = [
            'post_type' => $selectedPostType,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        // Alleen parent pages meenemen
        if ($parentPagesOnly) {
            $args['post_parent'] = 0;
        }

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == $selectedPostType) {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $pagesData[] = [
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'custom_title' => '',
                    'url' => get_permalink($post->ID),
                    'content' => $post->post_content,
                    'image_id' => has_post_thumbnail($post->ID) ? get_post_thumbnail_id($post->ID) : 0,
                    'featured_image_id' => has_post_thumbnail($post->ID) ? get_post_thumbnail_id($post->ID) : 0,
                ];
            }
        }
        wp_reset_postdata();
    } else {
    // Use manually selected pages
    for ($i = 0; $i < $numPages; $i++) {
        $pageId      = $block['data']["pages_{$i}_page"] ?? 0;
        $imageIdRaw  = $block['data']["pages_{$i}_image"] ?? 0;
        $externalUrl = $block['data']["pages_{$i}_external_url"] ?? '';

        // Normalize imageId to a valid attachment ID (int)
        $imageId = 0;
        if (is_array($imageIdRaw)) {
            $imageId = intval($imageIdRaw['id'] ?? $imageIdRaw['ID'] ?? 0);
        } elseif (is_string($imageIdRaw)) {
            if (ctype_digit($imageIdRaw)) {
                $imageId = intval($imageIdRaw);
            } else {
                $url = $imageIdRaw;
                if (strpos($url, 'http') !== 0) {
                    // Likely a relative URL like /content/uploads/...
                    // Use WP home_url to concatenate correctly without breaking slashes
                    $url = home_url($url);
                }
                $aid = attachment_url_to_postid($url);
                $imageId = $aid ? intval($aid) : 0;
            }
        } else {
            $imageId = intval($imageIdRaw);
        }

        if ($pageId) {
            // Interne pagina
            $page = get_post($pageId);

            // If page_visual is 'image' and no direct image selected, try subfield 'images'
            if ($pageVisual === 'image' && empty($imageId)) {
                // 1) Direct field pages_{$i}_images may contain an image or array
                $imagesField = $block['data']["pages_{$i}_images"] ?? null;
                $normalizeToId = function($val){
                    if (is_array($val)) {
                        return intval($val['id'] ?? $val['ID'] ?? 0);
                    } elseif (is_string($val)) {
                        if (ctype_digit($val)) return intval($val);
                        $url = $val;
                        if (strpos($url, 'http') !== 0) { $url = home_url($url); }
                        $aid = attachment_url_to_postid($url);
                        return $aid ? intval($aid) : 0;
                    } else {
                        return intval($val);
                    }
                };
                $candId = $normalizeToId($imagesField);
                if (!$candId) {
                    // 2) Try scanning subkeys like pages_{$i}_images_0_image
                    foreach (($block['data'] ?? []) as $k => $v) {
                        if (strpos($k, "pages_{$i}_images") === 0) {
                            $tmpId = $normalizeToId($v);
                            if ($tmpId) { $candId = $tmpId; break; }
                        }
                    }
                }
                if ($candId) { $imageId = $candId; }
            }

            if ($page) {
                $pagesData[] = [
                    'id'                => $page->ID,
                    'title'             => $page->post_title,
                    'custom_title'      => $block['data']["pages_{$i}_custom_page_title"] ?? '',
                    'url'               => get_permalink($page->ID),
                    'content'           => $page->post_content,
                    'image_id'          => $imageId,
                    'featured_image_id' => has_post_thumbnail($page->ID) ? get_post_thumbnail_id($page->ID) : 0,
                ];
            }
            } elseif (!empty($externalUrl)) {
                // Externe link
                $pagesData[] = [
                    'id'                => 0,
                    'title'             => $block['data']["pages_{$i}_custom_page_title"] ?? $externalUrl,
                    'custom_title'      => $block['data']["pages_{$i}_custom_page_title"] ?? '',
                    'url'               => $externalUrl,
                    'content'           => '',
                    'image_id'          => $imageId,
                    'featured_image_id' => 0,
                ];
            }
        }
    }

    // Layout
    $autoplay = $block['data']['autoplay'] ?? false;
    $autoplaySpeed = isset($block['data']['autoplay_speed']) && $block['data']['autoplay_speed'] !== ''? (int)$block['data']['autoplay_speed'] * 1000 : 5000;


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';


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
    $hoverEffect = $block['data']['hover_effect'] ?? '';
    $hoverEffectClasses = [
        'lift-up' => 'group-hover:-translate-y-2 group-hover:md:-translate-y-4',
        'scale-up' => 'group-hover:scale-105',
        'scale-down' => 'group-hover:scale-95',
        'none' => ''
    ];
    $hoverEffectClass = $hoverEffectClasses[$hoverEffect] ?? '';

    $flyinEffect = $block['data']['flyin_effect'] ?? false;

    // Determine image view and initial background (for background_image mode)
    $imageView = $block['data']['image_view'] ?? 'normal_image';
    $initialBgId = 0;
    $initialBgUrl = '';
    if ($imageView === 'background_image' && !empty($pagesData)) {
        foreach ($pagesData as $p) {
            $pid = $pageVisual === 'image' ? ($p['image_id'] ?? 0) : ($p['featured_image_id'] ?? 0);
            if ($pid) { $initialBgId = $pid; $initialBgUrl = wp_get_attachment_image_url($pid, 'full'); break; }
        }
    }
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'uitgelichte-paginas' }}@endif"
         class="block-uitgelichte-paginas uitgelichte-paginas-section-{{ $randomNumber }} uitgelichte-paginas-{{ $randomNumber }}-custom-padding uitgelichte-paginas-{{ $randomNumber }}-custom-margin relative bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ $imageView === 'background_image' && $initialBgUrl ? $initialBgUrl : wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat;  @if($backgroundImageParallax) background-attachment: fixed; @endif background-size: cover; {{ $imageView === 'background_image' && $initialBgId ? \Theme\Helpers\FocalPoint::getBackgroundPosition($initialBgId) : \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">

        @if ($imageView === 'background_image')
            <div id="uitgelichte-fade-{{ $randomNumber }}" class="bg-fade-layer" style="position:absolute;inset:0;background-repeat:no-repeat;background-size:cover;opacity:0;transition:opacity 400ms ease;"></div>
        @endif
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
            <div class="block-content {{ $blockClass }} mx-auto">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if($blockWidth == 'fullscreen') px-8 @endif {{ $textClass }}">
                    @if ($subtitleIcon)
                        <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                    @endif
                    {!! $subTitle !!}
                </span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }} @if($blockWidth == 'fullscreen') px-8 @endif {{ $textClass }}">{!! $title !!}</h2>
                @endif
                @if ($text)
                    @include('components.content', [
                       'content' => apply_filters('the_content', $text),
                       'class' => 'mt-4 text-' . $textColor . ' ' . $textClass,
                    ])
                @endif

                @if ($pagesData)
                    <div class="py-8">
                        @if ($imageView === 'normal_image')
                            @php
                                $initialPreviewUrl = '';
                                $initialPreviewId = 0;
                                foreach ($pagesData as $p) {
                                    $pid = $pageVisual === 'image' ? ($p['image_id'] ?? 0) : ($p['featured_image_id'] ?? 0);
                                    if ($pid) { $initialPreviewId = $pid; $initialPreviewUrl = wp_get_attachment_image_url($pid, 'large'); break; }
                                }
                            @endphp
                            <div class="uitgelichte-paginas-{{ $randomNumber }} flex flex-col lg:flex-row gap-6">
                                <div class="w-full lg:w-1/2">
                                    <div class="page-items flex flex-col gap-y-4">
                                        @foreach ($pagesData as $page)
                                            @php
                                                $pageTitle = $page['title'] ?? '';
                                                $customPageTitle = $page['custom_title'] ?? '';
                                                $pageExcerpt = get_the_excerpt($page['id']);
                                                $pageUrl = $page['url'] ?? '';
                                                $imageId = $page['image_id'] ?? 0;
                                                $featuredImageId = $page['featured_image_id'] ?? '';

                                                $pageId = $page['id'];
                                                $postType = get_post_type($pageId);
                                                $terms = [];
                                                if ($postType === 'page') {
                                                    $terms = get_the_category($pageId) ?? [];
                                                } elseif ($postType === 'post') {
                                                    $terms = get_the_category($pageId) ?? [];
                                                } else {
                                                    // Fetch terms from the custom taxonomy 'CPT_categories'
                                                    $terms = get_the_terms($pageId, $postType . '_categories') ?? [];
                                                }

                                                // Determine preview image URL for this item
                                                $previewId = ($pageVisual === 'image') ? $imageId : $featuredImageId;
                                                $previewUrl = $previewId ? wp_get_attachment_image_url($previewId, 'large') : '';
                                            @endphp

                                            <div class="page-item w-fit @if ($flyinEffect) page-hidden @endif" @if($previewUrl) data-preview-url="{{ $previewUrl }}" @endif @if($initialPreviewId && $previewId == $initialPreviewId) data-initial="1" @endif>
                                                <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                                                   class="page-title font-bold text-{{ $pageTitleColor }} relative z-20">
                                                    {!! !empty($customPageTitle) ? $customPageTitle : $pageTitle !!}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($autoplay && count($pagesData) > 1)
                                        <div class="autoplay-progress mt-4">
                                            <div id="uitgelichte-progress-{{ $randomNumber }}" class="progress h-[5px] w-0 bg-current"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="w-full lg:w-1/2">
                                    <div class="relative w-full overflow-hidden {{ $borderRadius }}" style="aspect-ratio: 4 / 3;">
                                        @if ($initialPreviewUrl)
                                            <img id="uitgelichte-preview-{{ $randomNumber }}" src="{{ $initialPreviewUrl }}" alt="Voorbeeldafbeelding" class="h-full w-full object-cover transition-opacity duration-300" />
                                        @else
                                            <div id="uitgelichte-preview-{{ $randomNumber }}" class="h-full w-full bg-gray-100"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var container = document.querySelector('.uitgelichte-paginas-{{ $randomNumber }}');
                                    if (!container) return;
                                    var preview = document.getElementById('uitgelichte-preview-{{ $randomNumber }}');
                                    if (!preview) return;

                                    var items = container.querySelectorAll('.page-item');
                                    var activate = function(item){
                                        items.forEach(function(i){ i.classList.remove('active'); });
                                        if(item) item.classList.add('active');
                                    };

                                    // hover/focus handlers update preview and active state
                                    container.querySelectorAll('.page-item[data-preview-url]').forEach(function (item) {
                                        var url = item.getAttribute('data-preview-url');
                                        if (!url) return;
                                        var setPreview = function () {
                                            var targetUrl = url;
                                            // Preload first
                                            var pre = new Image();
                                            pre.onload = function(){
                                                if (preview.tagName === 'IMG') {
                                                    // Fade out current, then swap, then fade in
                                                    preview.style.transition = 'opacity 400ms ease';
                                                    preview.style.opacity = '0';
                                                    setTimeout(function(){
                                                        preview.src = targetUrl;
                                                        // force reflow
                                                        void preview.offsetWidth;
                                                        preview.style.opacity = '1';
                                                    }, 180);
                                                } else {
                                                    // If fallback div used, create an img with opacity 0 and fade in
                                                    var img = document.createElement('img');
                                                    img.className = 'h-full w-full object-cover';
                                                    img.alt = 'Voorbeeldafbeelding';
                                                    img.id = 'uitgelichte-preview-{{ $randomNumber }}';
                                                    img.src = targetUrl;
                                                    img.style.opacity = '0';
                                                    img.style.transition = 'opacity 400ms ease';
                                                    preview.replaceWith(img);
                                                    preview = img;
                                                    // allow DOM paint
                                                    requestAnimationFrame(function(){
                                                        img.style.opacity = '1';
                                                    });
                                                }
                                                activate(item);
                                            };
                                            pre.src = targetUrl;
                                        };
                                        item.addEventListener('mouseenter', setPreview);
                                        item.addEventListener('focus', setPreview, true);
                                    });

                                    // Also allow activation for items without preview URLs
                                    items.forEach(function (item) {
                                        if (!item.hasAttribute('data-preview-url')) {
                                            var setActiveOnly = function () { activate(item); };
                                            item.addEventListener('mouseenter', setActiveOnly);
                                            item.addEventListener('focus', setActiveOnly, true);
                                        }
                                    });

                                    // Set initial active
                                    var initial = container.querySelector('.page-item[data-initial="1"]') || items[0];
                                    if (initial) activate(initial);

                                    @if ($autoplay && $pagesData && count($pagesData) > 1)
                                    // Autoplay with pause/resume and progress indicator
                                    var autoplaySpeed = {{ $autoplaySpeed }};
                                    if (items.length > 1) {
                                        var arr = Array.prototype.slice.call(items);
                                        var currentIndex = initial ? arr.indexOf(initial) : 0;
                                        if (currentIndex < 0) currentIndex = 0;
                                        var progress = document.getElementById('uitgelichte-progress-{{ $randomNumber }}');
                                        var listEl = container.querySelector('.page-items');

                                        var timerId = null, rafId = null;
                                        var startTime = 0, paused = false;
                                        var cycleDuration = autoplaySpeed; // duration of current cycle
                                        var remaining = cycleDuration;     // remaining time in ms for current cycle
                                        var basePercent = 0;               // accumulated percent before current leg

                                        function updateProgress() {
                                            if (!progress) return;
                                            var elapsed = performance.now() - startTime;
                                            var legPct = (elapsed / cycleDuration) * (100 - basePercent);
                                            var pct = Math.min(100, basePercent + Math.max(0, legPct));
                                            progress.style.width = pct + '%';
                                            if (!paused) rafId = requestAnimationFrame(updateProgress);
                                        }

                                        function advance() {
                                            // go to next item
                                            currentIndex = (currentIndex + 1) % arr.length;
                                            arr[currentIndex].dispatchEvent(new Event('mouseenter'));
                                            // reset for next full cycle
                                            cycleDuration = autoplaySpeed;
                                            remaining = autoplaySpeed;
                                            basePercent = 0;
                                            if (progress) progress.style.width = '0%';
                                            startTime = performance.now();
                                            timerId = setTimeout(advance, remaining);
                                            rafId = requestAnimationFrame(updateProgress);
                                        }

                                        function startTimer(ms) {
                                            cycleDuration = ms;
                                            remaining = ms;
                                            basePercent = 0;
                                            if (progress) {
                                                progress.style.transition = 'none';
                                                progress.style.width = '0%';
                                                requestAnimationFrame(function(){ progress.style.transition = 'width 0s'; });
                                            }
                                            startTime = performance.now();
                                            paused = false;
                                            timerId = setTimeout(advance, remaining);
                                            rafId = requestAnimationFrame(updateProgress);
                                        }

                                        function pauseTimer() {
                                            if (paused) return;
                                            paused = true;
                                            clearTimeout(timerId);
                                            if (rafId) cancelAnimationFrame(rafId);
                                            var elapsed = performance.now() - startTime;
                                            var legPct = (elapsed / cycleDuration) * (100 - basePercent);
                                            basePercent = Math.min(100, basePercent + Math.max(0, legPct));
                                            remaining = Math.max(0, autoplaySpeed * (1 - basePercent / 100));
                                        }

                                        function resumeTimer() {
                                            if (!paused) return;
                                            paused = false;
                                            cycleDuration = remaining; // animate the rest of the time
                                            startTime = performance.now();
                                            timerId = setTimeout(advance, remaining);
                                            rafId = requestAnimationFrame(updateProgress);
                                        }

                                        // Pause when hovering an individual page-item; resume when leaving all items
                                        var hoverCount = 0;
                                        arr.forEach(function(it, idx){
                                            it.addEventListener('mouseenter', function(e){
                                                currentIndex = idx;
                                                if (!e.isTrusted) return; // ignore programmatic mouseenter from autoplay
                                                hoverCount++;
                                                pauseTimer();
                                            });
                                            it.addEventListener('mouseleave', function(e){
                                                if (!e.isTrusted) return; // only resume on real pointer leave
                                                hoverCount = Math.max(0, hoverCount - 1);
                                                if (hoverCount === 0) resumeTimer();
                                            });
                                            it.addEventListener('focus', function(){
                                                currentIndex = idx;
                                                pauseTimer();
                                            }, true);
                                            it.addEventListener('blur', function(){
                                                var anyFocused = arr.some(function(el){ return el.contains(document.activeElement); });
                                                if (!anyFocused) resumeTimer();
                                            }, true);
                                        });

                                        startTimer(autoplaySpeed);
                                    }
                                    @endif
                                });
                            </script>
                        @elseif ($imageView === 'background_image')
                            @php
                                // Render simple list but with data-preview-url so we can swap the section background on hover
                            @endphp
                            <div class="page-items flex flex-col gap-y-4">
                                @foreach ($pagesData as $page)
                                    @php
                                        $pageTitle = $page['title'] ?? '';
                                        $customPageTitle = $page['custom_title'] ?? '';
                                        $pageExcerpt = get_the_excerpt($page['id']);
                                        $pageUrl = $page['url'] ?? '';
                                        $imageId = $page['image_id'] ?? 0;
                                        $featuredImageId = $page['featured_image_id'] ?? '';

                                        $pageId = $page['id'];
                                        $postType = get_post_type($pageId);
                                        $terms = [];
                                        if ($postType === 'page') {
                                            $terms = get_the_category($pageId) ?? [];
                                        } elseif ($postType === 'post') {
                                            $terms = get_the_category($pageId) ?? [];
                                        } else {
                                            // Fetch terms from the custom taxonomy 'CPT_categories'
                                            $terms = get_the_terms($pageId, $postType . '_categories') ?? [];
                                        }

                                        $previewId = ($pageVisual === 'image') ? $imageId : $featuredImageId;
                                        $previewUrl = $previewId ? wp_get_attachment_image_url($previewId, 'full') : '';
                                    @endphp

                                    <div class="page-item w-fit @if ($flyinEffect) page-hidden @endif" @if($previewUrl) data-preview-url="{{ $previewUrl }}" data-bgpos="{{ get_post_meta($previewId, 'bg_pos_desktop', true) }}" @endif @if($initialBgId && $previewId == $initialBgId) data-initial="1" @endif>
                                        <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                                           class="page-title font-bold text-{{ $pageTitleColor }} relative z-20">
                                            {!! !empty($customPageTitle) ? $customPageTitle : $pageTitle !!}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if($autoplay && count($pagesData) > 1)
                                <div class="autoplay-progress mt-4">
                                    <div id="uitgelichte-progressbg-{{ $randomNumber }}" class="progress h-[5px] w-0 bg-current"></div>
                                </div>
                            @endif

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var section = document.querySelector('.uitgelichte-paginas-section-{{ $randomNumber }}');
                                    if (!section) return;
                                    var container = section; // same section contains the list

                                    var items = container.querySelectorAll('.page-item');
                                    var activate = function(item){
                                        items.forEach(function(i){ i.classList.remove('active'); });
                                        if(item) item.classList.add('active');
                                    };

                                    container.querySelectorAll('.page-item[data-preview-url]').forEach(function (item) {
                                        var url = item.getAttribute('data-preview-url');
                                        if (!url) return;
                                        var setBg = function () {
                                            var targetUrl = url;
                                            var pos = item.getAttribute('data-bgpos');
                                            var pre = new Image();
                                            pre.onload = function(){
                                                var fade = document.getElementById('uitgelichte-fade-{{ $randomNumber }}');
                                                if (fade) {
                                                    // prepare fade layer
                                                    fade.style.transition = 'opacity 400ms ease';
                                                    fade.style.backgroundImage = 'url(' + targetUrl + ')';
                                                    if (pos) fade.style.backgroundPosition = pos;
                                                    fade.style.opacity = '0';
                                                    void fade.offsetWidth;
                                                    fade.style.opacity = '1';
                                                    var onEnd = function(){
                                                        fade.removeEventListener('transitionend', onEnd);
                                                        section.style.backgroundImage = 'url(' + targetUrl + ')';
                                                        if (pos) section.style.backgroundPosition = pos;
                                                        fade.style.opacity = '0';
                                                    };
                                                    fade.addEventListener('transitionend', onEnd);
                                                } else {
                                                    section.style.backgroundImage = 'url(' + targetUrl + ')';
                                                    if (pos) section.style.backgroundPosition = pos;
                                                }
                                                activate(item);
                                            };
                                            pre.src = targetUrl;
                                        };
                                        item.addEventListener('mouseenter', setBg);
                                        item.addEventListener('focus', setBg, true);
                                    });

                                    // Also allow activation for items without preview URLs
                                    items.forEach(function (item) {
                                        if (!item.hasAttribute('data-preview-url')) {
                                            var setActiveOnly = function () { activate(item); };
                                            item.addEventListener('mouseenter', setActiveOnly);
                                            item.addEventListener('focus', setActiveOnly, true);
                                        }
                                    });

                                    // Set initial active
                                    var initial = container.querySelector('.page-item[data-initial="1"]') || items[0];
                                    if (initial) activate(initial);

                                    @if ($autoplay && $pagesData && count($pagesData) > 1)
                                    // Autoplay with pause/resume and progress indicator
                                    var autoplaySpeed = {{ $autoplaySpeed }};
                                    if (items.length > 1) {
                                        var arr = Array.prototype.slice.call(items);
                                        var currentIndex = initial ? arr.indexOf(initial) : 0;
                                        if (currentIndex < 0) currentIndex = 0;
                                        var progress = document.getElementById('uitgelichte-progressbg-{{ $randomNumber }}');
                                        var listEl = container.querySelector('.page-items');

                                        var timerId = null, rafId = null;
                                        var startTime = 0, paused = false;
                                        var cycleDuration = autoplaySpeed; // duration of current cycle
                                        var remaining = cycleDuration;     // remaining time in ms for current cycle
                                        var basePercent = 0;               // accumulated percent before current leg

                                        function updateProgress() {
                                            if (!progress) return;
                                            var elapsed = performance.now() - startTime;
                                            var legPct = (elapsed / cycleDuration) * (100 - basePercent);
                                            var pct = Math.min(100, basePercent + Math.max(0, legPct));
                                            progress.style.width = pct + '%';
                                            if (!paused) rafId = requestAnimationFrame(updateProgress);
                                        }

                                        function advance() {
                                            // go to next item
                                            currentIndex = (currentIndex + 1) % arr.length;
                                            arr[currentIndex].dispatchEvent(new Event('mouseenter'));
                                            // reset for next full cycle
                                            cycleDuration = autoplaySpeed;
                                            remaining = autoplaySpeed;
                                            basePercent = 0;
                                            if (progress) progress.style.width = '0%';
                                            startTime = performance.now();
                                            timerId = setTimeout(advance, remaining);
                                            rafId = requestAnimationFrame(updateProgress);
                                        }

                                        function startTimer(ms) {
                                            cycleDuration = ms;
                                            remaining = ms;
                                            basePercent = 0;
                                            if (progress) {
                                                progress.style.transition = 'none';
                                                progress.style.width = '0%';
                                                requestAnimationFrame(function(){ progress.style.transition = 'width 0s'; });
                                            }
                                            startTime = performance.now();
                                            paused = false;
                                            timerId = setTimeout(advance, remaining);
                                            rafId = requestAnimationFrame(updateProgress);
                                        }

                                        function pauseTimer() {
                                            if (paused) return;
                                            paused = true;
                                            clearTimeout(timerId);
                                            if (rafId) cancelAnimationFrame(rafId);
                                            var elapsed = performance.now() - startTime;
                                            var legPct = (elapsed / cycleDuration) * (100 - basePercent);
                                            basePercent = Math.min(100, basePercent + Math.max(0, legPct));
                                            remaining = Math.max(0, autoplaySpeed * (1 - basePercent / 100));
                                        }

                                        function resumeTimer() {
                                            if (!paused) return;
                                            paused = false;
                                            cycleDuration = remaining; // animate the rest of the time
                                            startTime = performance.now();
                                            timerId = setTimeout(advance, remaining);
                                            rafId = requestAnimationFrame(updateProgress);
                                        }

                                        // Pause when hovering an individual page-item; resume when leaving all items
                                        var hoverCount = 0;
                                        arr.forEach(function(it, idx){
                                            it.addEventListener('mouseenter', function(e){
                                                currentIndex = idx;
                                                if (!e.isTrusted) return; // ignore programmatic mouseenter from autoplay
                                                hoverCount++;
                                                pauseTimer();
                                            });
                                            it.addEventListener('mouseleave', function(e){
                                                if (!e.isTrusted) return; // only resume on real pointer leave
                                                hoverCount = Math.max(0, hoverCount - 1);
                                                if (hoverCount === 0) resumeTimer();
                                            });
                                            it.addEventListener('focus', function(){
                                                currentIndex = idx;
                                                pauseTimer();
                                            }, true);
                                            it.addEventListener('blur', function(){
                                                var anyFocused = arr.some(function(el){ return el.contains(document.activeElement); });
                                                if (!anyFocused) resumeTimer();
                                            }, true);
                                        });

                                        startTimer(autoplaySpeed);
                                    }
                                    @endif
                                });
                            </script>
                        @else
                            @foreach ($pagesData as $page)
                                @php
                                    $pageTitle = $page['title'] ?? '';
                                    $customPageTitle = $page['custom_title'] ?? '';
                                    $pageExcerpt = get_the_excerpt($page['id']);
                                    $pageUrl = $page['url'] ?? '';
                                    $imageId = $page['image_id'] ?? 0;
                                    $featuredImageId = $page['featured_image_id'] ?? '';

                                    $pageId = $page['id'];
                                    $postType = get_post_type($pageId);
                                    $terms = [];
                                    if ($postType === 'page') {
                                            $terms = get_the_category($pageId) ?? [];
                                        } elseif ($postType === 'post') {
                                            $terms = get_the_category($pageId) ?? [];
                                        } else {
                                        // Fetch terms from the custom taxonomy 'CPT_categories'
                                        $terms = get_the_terms($pageId, $postType . '_categories') ?? [];
                                    }
                                @endphp

                                <div class="page-item @if ($flyinEffect) page-hidden @endif">
                                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                                       class="page-title font-bold text-{{ $pageTitleColor }} relative z-20">
                                        {!! !empty($customPageTitle) ? $customPageTitle : $pageTitle !!}
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }}">
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
    .uitgelichte-paginas-{{ $randomNumber }}-custom-padding {
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

    .uitgelichte-paginas-{{ $randomNumber }}-custom-margin {
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

    .page-hidden {
        opacity: 0;
    }

    .page-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

@if ($flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pageItems = document.querySelectorAll('.page-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const pageItem = entry.target;

                        setTimeout(() => {
                            if (pageItem.classList.contains('page-hidden')) {
                                pageItem.classList.add('page-animated');
                                pageItem.classList.remove('page-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(pageItem);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            pageItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endif
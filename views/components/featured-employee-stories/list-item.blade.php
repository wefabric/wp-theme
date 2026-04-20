@php
    $fields = get_fields($employeeStory);

    $employeeStoryBackground = $block['data']['employee_story_background_color'] ?? 'none';
    $employeeStoryTextColor = $block['data']['employee_story_text_color'] ?? '';

    $employeeStoryTitle = get_the_title($employeeStory) ?? '';
    $employeeStoryUrl = get_permalink($employeeStory);
    $employeeStoryCustomUrl = $fields['link'] ?? '';
    $employeeStoryName = $fields['name'] ?? '';
    $employeeStoryText = $fields['employee_story_text'] ?? '';
    $employeeStoryFunction = $fields['function'] ?? '';
    $employeeStoryAvatarId = $fields['avatar'] ?? '';
    if (is_array($employeeStoryAvatarId)) {
        $employeeStoryAvatarId = $employeeStoryAvatarId['ID'] ?? ($employeeStoryAvatarId['id'] ?? '');
    }
    $employeeStoryLogoId = $fields['logo_image'] ?? '';
    if (is_array($employeeStoryLogoId)) {
        $employeeStoryLogoId = $employeeStoryLogoId['ID'] ?? ($employeeStoryLogoId['id'] ?? '');
    }
    $employeeStoryImageId = $fields['image'] ?? '';
    if (is_array($employeeStoryImageId)) {
        $employeeStoryImageId = $employeeStoryImageId['ID'] ?? ($employeeStoryImageId['id'] ?? '');
    }
    $employeeStoryVideoEmbed = $fields['video_embed'] ?? '';
    $employeeStoryVideoFile = $fields['video_file'] ?? '';

    $employeeStoryStars = $fields['star_rating'] ?? '';

    $employeeStoryLink = $block['data']['employee_story_link'] ?? 'employee_story_link';
    $imagePosition = $block['data']['image_position'] ?? 'right';

    $visibleElements = $block['data']['show_element'] ?? [];
    $employeeStoryCategories = get_the_terms($employeeStory, 'employee_story_categories') ?: [];

@endphp

<div class="employee-story-item custom-styling flex w-full h-full text-{{ $employeeStoryTextColor }} @if ($flyinEffect) employee-story-hidden @endif">

    <div class="employee-story-block relative w-full h-full min-h-[500px] flex flex-col bg-{{ $employeeStoryBackground }} rounded-{{ $borderRadius }} overflow-hidden">

        @php
            $videoUrl = '';
            $videoType = '';
            $videoFileUrl = '';
            
            if (!empty($employeeStoryVideoFile)) {
                if (is_array($employeeStoryVideoFile)) {
                    $videoFileUrl = $employeeStoryVideoFile['url'] ?? '';
                } else {
                    $videoFileUrl = is_numeric($employeeStoryVideoFile) ? wp_get_attachment_url($employeeStoryVideoFile) : $employeeStoryVideoFile;
                }
                if ($videoFileUrl) {
                   $videoType = 'file';
                   $videoUrl = $videoFileUrl;
                }
            }
            
            if (!$videoUrl && !empty($employeeStoryVideoEmbed)) {
                if (is_array($employeeStoryVideoEmbed)) {
                    $videoUrl = $employeeStoryVideoEmbed['url'] ?? ($employeeStoryVideoEmbed['embed'] ?? '');
                } else {
                    $videoUrl = $employeeStoryVideoEmbed;
                }
                $videoType = 'embed';
            }

            $videoSetting = $block['data']['video_setting'] ?? 'standard';
        @endphp

        {{-- Background Section --}}
        <div class="absolute inset-0 z-0">
            @if (!empty($visibleElements) && in_array('video', $visibleElements) && ($videoUrl))
                <div class="employee-story-video w-full h-full relative">
                    @if ($videoType === 'file')
                        <video class="video-item w-full h-full object-cover"
                               @if($videoSetting === 'automatic') autoplay muted loop playsinline @endif
                               @if($videoSetting === 'on_hover') muted loop playsinline @endif
                               preload="metadata">
                            <source src="{{ $videoUrl }}">
                            Your browser does not support the video tag.
                        </video>

                        @if($videoSetting === 'automatic')
                            <script>
                                (function() {
                                    const vid = document.currentScript.previousElementSibling;
                                    if(!vid) return;
                                    const onChange = (entries)=>{
                                        entries.forEach(entry=>{
                                            if(entry.isIntersecting){ vid.play().catch(()=>{}); }
                                            else { vid.pause(); }
                                        });
                                    };
                                    const io = new IntersectionObserver(onChange, { threshold: 0.2 });
                                    io.observe(vid);
                                })();
                            </script>
                        @elseif($videoSetting === 'on_hover')
                            <script>
                                (function() {
                                    const vid = document.currentScript.previousElementSibling;
                                    if(!vid) return;

                                    const isMobile = () => window.innerWidth < 768;

                                    if (isMobile()) {
                                        const container = vid.parentElement;
                                        const overlay = document.createElement('div');
                                        overlay.className = 'video-mobile-overlay absolute inset-0 z-[5] cursor-pointer';
                                        container.appendChild(overlay);

                                        overlay.addEventListener('click', function(e) {
                                            const videoSrc = vid.querySelector('source').src;
                                            const lightbox = GLightbox({
                                                elements: [
                                                    {
                                                        'href': videoSrc,
                                                        'type': 'video',
                                                        'source': 'local',
                                                        'width': '90vw',
                                                    }
                                                ],
                                                autoplayVideos: true,
                                            });
                                            lightbox.open();
                                        });
                                    } else {
                                        const startPlaying = ()=>{ if(vid.paused){ vid.play().catch(()=>{}); } };
                                        const stopPlaying = ()=>{ vid.pause(); };
                                        vid.addEventListener('mouseenter', startPlaying);
                                        vid.addEventListener('mouseleave', stopPlaying);
                                        let started = false;
                                        vid.addEventListener('touchstart', function(){
                                            if(!started){ vid.play().catch(()=>{}); started = true; }
                                            else { vid.pause(); started = false; }
                                        }, {passive:true});
                                    }
                                })();
                            </script>
                        @elseif($videoSetting === 'standard')
                            <div class="video-overlay absolute inset-0 flex items-center justify-center z-10 cursor-pointer">
                                <button aria-label="Play video" class="play-button w-16 h-16 rounded-full bg-white/70 text-black flex items-center justify-center shadow-lg transition-transform hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                </button>
                            </div>

                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
                            <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

                            <script>
                                (function() {
                                    const container = document.currentScript.parentElement;
                                    const vid = container.querySelector('video.video-item');
                                    const overlay = container.querySelector('.video-overlay');
                                    if(!vid || !overlay) return;

                                    vid.removeAttribute('autoplay');
                                    vid.pause();

                                    const isMobile = () => window.innerWidth < 768;

                                    overlay.addEventListener('click', function(e){
                                        if (isMobile()) {
                                            const videoSrc = vid.querySelector('source').src;
                                            const lightbox = GLightbox({
                                                elements: [
                                                    {
                                                        'href': videoSrc,
                                                        'type': 'video',
                                                        'source': 'local',
                                                        'width': '90vw',
                                                    }
                                                ],
                                                autoplayVideos: true,
                                            });
                                            lightbox.open();
                                        } else {
                                            overlay.style.display = 'none';
                                            vid.muted = false;
                                            vid.controls = true;
                                            vid.removeAttribute('loop');
                                            vid.play().catch(()=>{});
                                        }
                                    });
                                })();
                            </script>
                        @endif
                    @else
                        @php
                            $html = '';
                            $val = $videoUrl;
                            if (is_string($val)) {
                                if (strpos($val, '<iframe') !== false) {
                                    $html = $val;
                                } else {
                                    $oembed = function_exists('wp_oembed_get') ? wp_oembed_get($val) : '';
                                    if ($oembed) {
                                        $html = $oembed;
                                    } else {
                                        $src = $val;
                                        $ytId = '';
                                        $vmId = '';
                                        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{6,})~', $val, $m) || preg_match('~youtube\.com/watch\\?v=([A-Za-z0-9_-]{6,})~', $val, $m) || preg_match('~youtube\.com/embed/([A-Za-z0-9_-]{6,})~',$val,$m) || preg_match('~youtube\.com/shorts/([A-Za-z0-9_-]{6,})~',$val,$m)) {
                                            $ytId = $m[1];
                                        }
                                        if (!$ytId && preg_match('~vimeo\.com/(?:video/)?(\d+)~', $val, $m)) {
                                            $vmId = $m[1];
                                        }
                                        if ($ytId) {
                                            $params = 'rel=0&modestbranding=1&playsinline=1';
                                            if ($videoSetting === 'automatic' || $videoSetting === 'on_hover') {
                                                $params .= '&autoplay=1&mute=1&loop=1&playlist=' . $ytId . '&controls=0';
                                            }
                                            $src = 'https://www.youtube.com/embed/' . $ytId . '?' . $params;
                                        } elseif ($vmId) {
                                            $src = 'https://player.vimeo.com/video/' . $vmId;
                                            if ($videoSetting === 'automatic' || $videoSetting === 'on_hover') {
                                                $src .= '?autoplay=1&muted=1&loop=1&background=1';
                                            }
                                        }
                                        $html = '<iframe width="100%" height="100%" src="' . esc_url($src) . '" title="Video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                                    }
                                }
                            }
                        @endphp
                        <div class="video-embed-wrapper absolute inset-0 pointer-events-none overflow-hidden">
                            {!! $html !!}
                        </div>

                        <style>
                            .video-embed-wrapper iframe {
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                width: 100%;
                                height: 100%;
                                transform: translate(-50%, -50%);
                                pointer-events: none;
                            }
                            
                            /* YouTube/Vimeo cover effect voor 16:9 videos */
                            @media (min-aspect-ratio: 16/9) {
                                .video-embed-wrapper iframe {
                                    height: 300%; /* Overscale height to ensure coverage */
                                    width: 100%;
                                }
                            }
                            
                            @media (max-aspect-ratio: 16/9) {
                                .video-embed-wrapper iframe {
                                    width: 300%; /* Overscale width to ensure coverage */
                                    height: 100%;
                                }
                            }

                            /* Voor Shorts en andere embeds, gebruik object-fit: cover 
                               Modernere browsers ondersteunen dit op iframes om de content te schalen */
                            .video-embed-wrapper iframe {
                                object-fit: cover;
                                width: 100%;
                                height: 100%;
                                min-width: 100%;
                                min-height: 100%;
                            }
                        </style>

                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
                        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
                        <script>
                            (function() {
                                const container = document.currentScript.parentElement;
                                const isMobile = () => window.innerWidth < 768;
                                const videoUrl = "{{ $videoUrl }}";

                                if (isMobile()) {
                                    const overlay = document.createElement('div');
                                    overlay.className = 'video-embed-mobile-overlay absolute inset-0 z-[5] cursor-pointer';
                                    container.appendChild(overlay);

                                    overlay.addEventListener('click', function(e) {
                                        const lightbox = GLightbox({
                                            elements: [
                                                {
                                                    'href': videoUrl,
                                                    'type': 'video',
                                                    'source': videoUrl.includes('vimeo') ? 'vimeo' : 'youtube',
                                                    'width': '90vw',
                                                }
                                            ],
                                            autoplayVideos: true,
                                        });
                                        lightbox.open();
                                    });
                                } else {
                                    @if($videoSetting === 'standard')
                                        const overlay = document.createElement('div');
                                        overlay.className = 'video-embed-standard-overlay absolute inset-0 z-[5] cursor-pointer flex items-center justify-center bg-black/10';
                                        overlay.innerHTML = '<button aria-label="Play video" class="play-button w-16 h-16 rounded-full bg-white/70 text-black flex items-center justify-center shadow-lg transition-transform hover:scale-110"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg></button>';
                                        container.appendChild(overlay);

                                        overlay.addEventListener('click', function(e) {
                                            const lightbox = GLightbox({
                                                elements: [
                                                    {
                                                        'href': videoUrl,
                                                        'type': 'video',
                                                        'source': videoUrl.includes('vimeo') ? 'vimeo' : 'youtube',
                                                        'width': '90vw',
                                                    }
                                                ],
                                                autoplayVideos: true,
                                            });
                                            lightbox.open();
                                        });
                                    @endif
                                }
                            })();
                        </script>
                    @endif
                </div>
            @elseif (!empty($visibleElements) && in_array('image', $visibleElements) && $employeeStoryImageId)
                <div class="employee-story-image w-full h-full">
                    @include('components.image', [
                        'image_id' => $employeeStoryImageId,
                        'size' => 'full',
                        'object_fit' => 'cover',
                        'img_class' => 'h-full w-full object-cover',
                        'alt' => $employeeStoryTitle,
                    ])
                </div>
            @endif
            {{-- Dark overlay for readability --}}
            <div class="absolute inset-0 bg-black/40 z-[1] pointer-events-none"></div>
        </div>

        @if (!empty($employeeStoryCategories) && !is_wp_error($employeeStoryCategories) && in_array('category', $visibleElements))
            <div class="employee-story-categories absolute z-20 top-[15px] @if($imagePosition == 'right') image-right right-[15px] @else image-left left-[15px] @endif flex flex-wrap gap-2">
                @foreach ($employeeStoryCategories as $category)
                    @php
                        $categoryColor = get_field('category_color', $category);
                        $categoryIcon = get_field('category_icon', $category);
                        $categoryImage = get_field('category_image', $category);
                    @endphp
                    <div style="background-color: {{ $categoryColor }}"
                         class="employee-story-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                        @if($categoryImage)
                            <img src="{{ wp_get_attachment_image_url($categoryImage, 'thumbnail') }}" alt="{{ $category->name }}" class="w-5 h-5 object-contain">
                        @endif
                        {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="content-section relative z-[2] flex flex-col justify-end w-full h-full p-8 lg:p-16 pointer-events-none">

            @if (!empty($visibleElements) && in_array('quote', $visibleElements))
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="quote-icon block w-8 h-8 mb-2 md:mb-6 order-1"
                     viewBox="0 0 975.036 975.036">
                    <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                </svg>
            @endif

            <div class="avatar-section flex items-center bg-white/10 backdrop-blur-md p-4 rounded-xl gap-x-4 md:gap-x-6 mb-6 order-2 w-fit pointer-events-auto">
                @if (!empty($visibleElements) && in_array('avatar_image', $visibleElements) && $employeeStoryAvatarId)
                    <div class="avatar-image-section">
                        @include('components.image', [
                            'image_id' => $employeeStoryAvatarId,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'avatar-image w-16 h-16 md:w-20 md:h-20 aspect-square rounded-lg object-cover object-center',
                            'alt' => $employeeStoryTitle,
                        ])
                    </div>
                @endif
                @if ($employeeStoryName || $employeeStoryFunction)
                    <div class="avatar-details text-white">
                        @if (!empty($visibleElements) && in_array('name', $visibleElements) && $employeeStoryName)
                            <div class="name-text font-bold text-lg md:text-xl">{!! $employeeStoryName !!}</div>
                        @endif
                        @if (!empty($visibleElements) && in_array('function', $visibleElements) && $employeeStoryFunction)
                            <div class="function-text opacity-80 text-sm md:text-base">{!! $employeeStoryFunction !!}</div>
                        @endif
                    </div>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('star_rating', $visibleElements) && $employeeStoryStars)
                <div class="star-rating flex items-center mb-4 text-[24px] order-3">
                    @php
                        $fullStars = floor($employeeStoryStars);
                        $hasHalfStar = $employeeStoryStars - $fullStars >= 0.5;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star text-yellow-500"></i>
                        @elseif ($i == $fullStars + 1 && $hasHalfStar)
                            <i class="fas fa-star-half-alt text-yellow-500"></i>
                        @else
                            <i class="far fa-star text-yellow-500"></i>
                        @endif
                    @endfor
                </div>
            @endif

            @if (!empty($visibleElements) && in_array('employee_story_text', $visibleElements) && $employeeStoryText)
                <div class="employee-story-text-wrapper mb-6 order-4 text-white">
                    @include('components.content', ['content' => apply_filters('the_content', $employeeStoryText), 'class' => '!p-0'])
                </div>
            @endif

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @php
                    $buttonUrl = '';
                    if ($employeeStoryLink === 'employee_story_link') {
                        $buttonUrl = $employeeStoryUrl;
                    } elseif ($employeeStoryLink === 'custom_link' && !empty($employeeStoryCustomUrl)) {
                        $buttonUrl = $employeeStoryCustomUrl;
                    }
                @endphp

                @if ($buttonCardText && $buttonUrl)
                    <div class="employee-story-button mt-4 z-10 order-5 pointer-events-auto">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $buttonUrl,
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
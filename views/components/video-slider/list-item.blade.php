@if ($video['url'])
    <div class="flex flex-col lg:flex-row items-center gap-x-8 gap-y-4 @if(!$video['caption']) justify-center @endif">
        <div class="video-container {{ $videoFormatClass ?? 'aspect-video' }} w-full  @if ($video['caption']) lg:w-3/5 @endif relative">
            @if(isset($video['type']) && $video['type'] === 'file')
                <video class="video-item w-full h-full object-cover rounded-{{ $borderRadius }}"
                    @if($videoSetting === 'automatic') autoplay muted loop playsinline @endif
                    @if($videoSetting === 'on_hover') muted loop playsinline @endif
                    preload="metadata">
                    <source src="{{ $video['url'] }}">
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
                            const startPlaying = ()=>{ if(vid.paused){ vid.play().catch(()=>{}); } };
                            const stopPlaying = ()=>{ vid.pause(); };
                            vid.addEventListener('mouseenter', startPlaying);
                            vid.addEventListener('mouseleave', stopPlaying);
                            let started = false;
                            vid.addEventListener('touchstart', function(){
                                if(!started){ vid.play().catch(()=>{}); started = true; }
                                else { vid.pause(); started = false; }
                            }, {passive:true});
                        })();
                    </script>
                @elseif($videoSetting === 'standard')
                    <div class="video-overlay absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                        <button aria-label="Play video" class="play-button pointer-events-auto w-16 h-16 rounded-full bg-white/70 text-black flex items-center justify-center shadow-lg transition-transform hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                    <script>
                        (function() {
                            const container = document.currentScript.parentElement;
                            const vid = container.querySelector('video.video-item');
                            const btn = container.querySelector('.play-button');
                            const overlay = container.querySelector('.video-overlay');
                            if(!vid || !btn) return;
                            vid.removeAttribute('autoplay');
                            vid.pause();
                            btn.addEventListener('click', function(){
                                if(overlay){ overlay.style.display = 'none'; }
                                vid.muted = false;
                                vid.controls = true;
                                vid.removeAttribute('loop');
                                vid.play().catch(()=>{});
                            });
                        })();
                    </script>
                @endif
            @else
                @php $val = $video['url']; @endphp
                @if (is_string($val) && strpos($val, '<') !== false)
                    {!! $val !!}
                @else
                    @php
                        $html = '';
                        if (is_string($val)) {
                            $oembed = function_exists('wp_oembed_get') ? wp_oembed_get($val) : '';
                            if ($oembed) {
                                $html = $oembed;
                            } else {
                                $src = $val;
                                $ytId = '';
                                $vmId = '';
                                if (preg_match('~youtu\.be/([A-Za-z0-9_-]{6,})~', $val, $m) || preg_match('~youtube\.com/watch\\?v=([A-Za-z0-9_-]{6,})~', $val, $m) || preg_match('~youtube\.com/embed/([A-Za-z0-9_-]{6,})~',$val,$m)) {
                                    $ytId = $m[1];
                                }
                                if (!$ytId && preg_match('~vimeo\.com/(?:video/)?(\d+)~', $val, $m)) {
                                    $vmId = $m[1];
                                }
                                if ($ytId) {
                                    $params = 'rel=0&modestbranding=1&playsinline=1';
                                    $src = 'https://www.youtube.com/embed/' . $ytId . '?' . $params;
                                } elseif ($vmId) {
                                    $src = 'https://player.vimeo.com/video/' . $vmId;
                                }
                                $html = '<iframe width="100%" height="100%" src="' . esc_url($src) . '" title="Video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                            }
                        }
                    @endphp
                    {!! $html !!}
                @endif
            @endif
        </div>
        @if ($video['caption'])
            <div class="h3 text-{{ $captionTextColor }} font-bold text-left w-full lg:w-2/5">{{ $video['caption'] }}</div>
        @endif
    </div>

    @php
        $videoUrl = is_string($video['url']) ? $video['url'] : '';
        $thumbnailUrl = '';

        if ($videoUrl && (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false)) {
            $youtubeId = basename(parse_url($videoUrl, PHP_URL_PATH));
            $thumbnailUrl = "https://img.youtube.com/vi/{$youtubeId}/0.jpg";
        } elseif ($videoUrl && strpos($videoUrl, 'vimeo.com') !== false) {
            $vimeoId = basename(parse_url($videoUrl, PHP_URL_PATH));
            $thumbnailUrl = "https://vumbnail.com/{$vimeoId}.jpg";
        }
    @endphp

{{--    <script type="application/ld+json">--}}
{{--        {--}}
{{--            "@context": "https://schema.org",--}}
{{--            "@type": "VideoObject",--}}
{{--            "name": "{{ $title }}",--}}
{{--            "description": "{{ $video['caption'] ?? 'Bekijk deze video' }}",--}}
{{--            "thumbnailUrl": "{{ $thumbnailUrl }}",--}}
{{--            "uploadDate": "{{ now()->toIso8601String() }}",--}}
{{--            "contentUrl": "{{ is_string($video['url']) ? $video['url'] : '' }}",--}}
{{--            "embedUrl": "{{ is_string($video['url']) ? $video['url'] : '' }}",--}}
{{--            "publisher": {--}}
{{--                "@type": "Organization",--}}
{{--                "name": "{{ get_bloginfo('name') }}"--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
@endif
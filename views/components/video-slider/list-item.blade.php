@if ($video['url'])
    <div class="flex flex-col lg:flex-row items-center gap-x-8 gap-y-4 @if(!$video['caption']) justify-center @endif">
        <div class="video-container aspect-video w-full  @if ($video['caption']) lg:w-3/5 @endif">
            @if(isset($video['type']) && $video['type'] === 'file')
                <video controls playsinline preload="metadata" style="width:100%;height:100%">
                    <source src="{{ $video['url'] }}">
                </video>
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
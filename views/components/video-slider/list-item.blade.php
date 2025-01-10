@if ($video['url'])
    <div class="flex flex-col lg:flex-row items-center gap-x-8 gap-y-4 @if(!$video['caption']) justify-center @endif">
        <div class="video-container aspect-video w-full lg:w-3/5">
            <iframe width="100%" height="100%" src="{{ $video['url'] }}" title="Video player" frameborder="0" allowfullscreen></iframe>
        </div>
        @if ($video['caption'])
            <p class="h3 text-{{ $captionTextColor }} font-bold text-left w-full lg:w-2/5">{{ $video['caption'] }}</p>
        @endif
    </div>

    @php
        $videoUrl = $video['url'];
        $thumbnailUrl = '';

        if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
            $youtubeId = basename(parse_url($videoUrl, PHP_URL_PATH));
            $thumbnailUrl = "https://img.youtube.com/vi/{$youtubeId}/0.jpg";
        } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
            $vimeoId = basename(parse_url($videoUrl, PHP_URL_PATH));
            $thumbnailUrl = "https://vumbnail.com/{$vimeoId}.jpg";
        }
    @endphp

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "VideoObject",
        "name": "{{ $title }}",
        "description": "{{ $video['caption'] ?? 'Bekijk deze video' }}",
        "thumbnailUrl": "{{ $thumbnailUrl }}",
        "uploadDate": "{{ now()->toIso8601String() }}",
        "contentUrl": "{{ $video['url'] }}",
        "embedUrl": "{{ $video['url'] }}",
        "publisher": {
            "@type": "Organization",
            "name": "{{ get_bloginfo('name') }}"
        }
    }
    </script>
@endif
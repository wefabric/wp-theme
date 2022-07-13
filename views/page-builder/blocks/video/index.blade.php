<div class="{{ $classes ?? '' }} mx-auto {{ $block->get('width') }}">
    @if($block['video'])
        @if(strpos($block['video'], 'youtube') > 0)
            @php
                $video_id = $block['video'];
                $anchor = '?v=';
                if($i = strpos($video_id, $anchor)) {
                    $video_id = substr($video_id, $i + strlen($anchor));
                    if($j = strpos($video_id, '&')){ // if there's anything appended after the video ID, remove that too.
                        $video_id = substr($video_id, 0, $j);
                    }
                }

                $iframe = 'src="https://www.youtube-nocookie.com/embed/'. $video_id .'" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"';
            @endphp
        @elseif(strpos($block['video'],'vimeo') > 0)
            @php
                $video_id = $block['video'];
                $anchor = '/'; //find the last / in the URL.
                if($i = strrpos($video_id, $anchor)) {
                    $video_id = substr($video_id, $i + strlen($anchor));
                    if($j = strpos($video_id, '?')){ // if there's anything appended after the video ID, remove that too.
                        $video_id = substr($video_id, 0, $j);
                    }
                }

                $iframe = 'src="https://player.vimeo.com/video/'. $video_id .'" title="Vimeo video player" allow="autoplay; fullscreen; picture-in-picture"';
            @endphp
        @endif

        @if(isset($iframe))
            <div class="video-container">
                <iframe width="100%" height="100%" allowfullscreen {!! $iframe !!} ></iframe>
            </div>
        @endif

    @endif
</div>

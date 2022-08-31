@if($item['video'])
    @if(strpos($item['video'], 'youtube') > 0)
        @php
            $video_id = $item['video']; //ex: https://www.youtube.com/watch?v=EUtB6u2VVkE&ab_channel=OLDTAPES
            $anchor = '?v=';
            if($i = strpos($video_id, $anchor)) {
                $video_id = substr($video_id, $i + strlen($anchor));
                if($j = strpos($video_id, '&')){ // if there's anything appended after the video ID, remove that too.
                    $video_id = substr($video_id, 0, $j);
                }
            }

            $iframe = 'src="https://www.youtube-nocookie.com/embed/'. $video_id .'" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"';
        @endphp
    @elseif(strpos($item['video'],'vimeo') > 0)
        @php
            $video_id = $item['video']; //ex: https://vimeo.com/722540072/6198d87a12
            $anchor = 'vimeo.com/';
			if($i = strrpos($video_id, $anchor)) {
                $video_id = substr($video_id, $i + strlen($anchor));

				if(str_contains($video_id, '/')) {
    				$video_id = str_replace('/', '?h=', $video_id);
				}
            }
            $iframe = 'src="https://player.vimeo.com/video/'. $video_id .'" title="Vimeo video player" allow="autoplay; fullscreen; picture-in-picture"';
        @endphp
    @endif

    @if(isset($iframe))
        <div>
            <div class="title">
                {{ $item['title'] }}
            </div>
            <div class="iframe-container">
                <iframe width="100%" height="100%" allowfullscreen {!! $iframe !!} ></iframe>
            </div>
            <div class="text">
                {{ '' }}
            </div>
        </div>
    @endif

@endif
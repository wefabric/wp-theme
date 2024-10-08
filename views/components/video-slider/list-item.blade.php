@if ($video['url'])
    <div class="flex flex-col lg:flex-row items-center gap-x-8 gap-y-4 @if(!$video['caption']) justify-center @endif">
        <div class="video-container aspect-video w-full lg:w-3/5">
            <iframe width="100%" height="100%" src="{{ $video['url'] }}" title="YouTube video player" frameborder="0" allowfullscreen></iframe>
        </div>
        @if ($video['caption'])
            <p class="h3 text-{{ $captionTextColor }} font-bold text-left w-full lg:w-2/5">{{ $video['caption'] }}</p>
        @endif
    </div>
@endif
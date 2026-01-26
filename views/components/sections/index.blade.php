<section id="@if($customBlockId){{ $customBlockId }}@else{{ $blockType }}@endif" class="block-{{$blockType}} block-{{ $randomNumber }} relative {{$blockType}}-{{ $randomNumber }}-custom-padding {{$blockType}}-{{ $randomNumber }}-custom-margin {{ $backgroundClass }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    {{ $slot }}
</section>

{!! $styling && $styling->isNotEmpty() ? $styling->toInlineCss($blockType, $randomNumber) : '' !!}
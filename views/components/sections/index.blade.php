<section id="@if($customBlockId){{ $customBlockId }}@else{{ $blockType }}@endif" class="block-{{$blockType}} block-{{ $randomNumber }} relative tekst-{{ $randomNumber }}-custom-padding tekst-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    {{ $slot }}
</section>

@if($styling->isNotEmpty())
    <style>
        @if($styling->screenPaddings->where('enabled', true)->first())
            .{{$blockType}}-{{ $randomNumber }}-custom-padding {
                @foreach($styling->screenPaddings as $screenPaddingData)
                    @media only screen and (min-width: {{$screenPaddingData->get('size') }}px) {
                        @if($screenPaddingData->get('top')) padding-top: {{ $screenPaddingData->get('top') }}px; @endif
                        @if($screenPaddingData->get('right')) padding-right: {{ $screenPaddingData->get('right') }}px; @endif
                        @if($screenPaddingData->get('bottom')) padding-bottom: {{ $screenPaddingData->get('bottom') }}px; @endif
                        @if($screenPaddingData->get('left')) padding-left: {{ $screenPaddingData->get('left') }}px; @endif
                    }
                @endforeach
            }
        @endif

        @if($styling->screenMargins->where('enabled', true)->first())
            .{{$blockType}}-{{ $randomNumber }}-custom-margin {
                @foreach($styling->screenMargins as $screenMarginData)
                    @media only screen and (min-width: {{$screenMarginData->get('size') }}px) {
                    @if($screenMarginData->get('top')) margin-top: {{ $screenMarginData->get('top') }}px; @endif
                        @if($screenMarginData->get('right')) margin-right: {{ $screenMarginData->get('right') }}px; @endif
                        @if($screenMarginData->get('bottom')) margin-bottom: {{ $screenMarginData->get('bottom') }}px; @endif
                        @if($screenMarginData->get('left')) margin-left: {{ $screenMarginData->get('left') }}px; @endif
                    }
              @endforeach
            }
        @endif
    </style>
@endif
<section id="@if($customBlockId){{ $customBlockId }}@else{{ $blockType }}@endif" class="block-{{$blockType}} block-{{ $randomNumber }} relative tekst-{{ $randomNumber }}-custom-padding tekst-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">

    {{ $slot }}
</section>

<style>
    .{{$blockType}}-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($padding['mobile']['top']) padding-top: {{ $padding['mobile']['top'] }}px; @endif
            @if($padding['mobile']['right']) padding-right: {{ $padding['mobile']['right'] }}px; @endif
            @if($padding['mobile']['bottom']) padding-bottom: {{ $padding['mobile']['bottom'] }}px; @endif
            @if($padding['mobile']['left']) padding-left: {{ $padding['mobile']['left'] }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($padding['tablet']['top']) padding-top: {{ $padding['tablet']['top'] }}px; @endif
            @if($padding['tablet']['right']) padding-right: {{ $padding['tablet']['right'] }}px; @endif
            @if($padding['tablet']['bottom']) padding-bottom: {{ $padding['tablet']['bottom'] }}px; @endif
            @if($padding['tablet']['left']) padding-left: {{ $padding['tablet']['left'] }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($padding['desktop']['top']) padding-top: {{ $padding['desktop']['top'] }}px; @endif
            @if($padding['desktop']['right']) padding-right: {{ $padding['desktop']['right'] }}px; @endif
            @if($padding['desktop']['bottom']) padding-bottom: {{ $padding['desktop']['bottom'] }}px; @endif
            @if($padding['desktop']['left']) padding-left: {{ $padding['desktop']['left'] }}px; @endif
        }
    }

    .{{$blockType}}-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($margin['mobile']['top']) margin-top: {{ $margin['mobile']['top'] }}px; @endif
            @if($margin['mobile']['right']) margin-right: {{ $margin['mobile']['right'] }}px; @endif
            @if($margin['mobile']['bottom']) margin-bottom: {{ $margin['mobile']['bottom'] }}px; @endif
            @if($margin['mobile']['left']) margin-left: {{ $margin['mobile']['left'] }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($margin['tablet']['top']) margin-top: {{ $margin['tablet']['top'] }}px; @endif
            @if($margin['tablet']['right']) margin-right: {{ $margin['tablet']['right'] }}px; @endif
            @if($margin['tablet']['bottom']) margin-bottom: {{ $margin['tablet']['bottom'] }}px; @endif
            @if($margin['tablet']['left']) margin-left: {{ $margin['tablet']['left'] }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($margin['desktop']['top']) margin-top: {{ $margin['desktop']['top'] }}px; @endif
            @if($margin['desktop']['right']) margin-right: {{ $margin['desktop']['right'] }}px; @endif
            @if($margin['desktop']['bottom']) margin-bottom: {{ $margin['desktop']['bottom'] }}px; @endif
            @if($margin['desktop']['left']) margin-left: {{ $margin['desktop']['left'] }}px; @endif
        }
    }
</style>
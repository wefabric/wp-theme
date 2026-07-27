{{--
    De achtergrond van een headerblok als <img> in plaats van een CSS-achtergrond.

    Een background-image dwingt altijd het volledige bestand af, ook op een telefoon. Met een
    <img> vult WordPress zelf srcset en sizes, zodat de browser een passende variant kiest.
    Op het headerbeeld, doorgaans het LCP-element, scheelt dat het meeste.

    Wordt alleen ingeladen wanneer parallax uit staat: background-attachment: fixed heeft geen
    equivalent op een <img>. De aanroepende template regelt die keuze.

    @var int    $backgroundImageId  Attachment-ID van het headerbeeld.
    @var string $imageClass         Extra klassen, optioneel.
--}}
@php
    $imageClass = $imageClass ?? '';
@endphp

{!! wp_get_attachment_image($backgroundImageId, 'full', false, [
    'class'         => trim('header-background-image absolute inset-0 w-full h-full object-cover ' . $imageClass),
    'style'         => \Theme\Helpers\FocalPoint::getObjectPosition((int) $backgroundImageId),
    // Het headerbeeld staat boven de vouw, dus niet lui laden en met voorrang ophalen.
    'loading'       => 'eager',
    'fetchpriority' => 'high',
    'decoding'      => 'async',
    'sizes'         => '100vw',
    // Decoratief: de kop ernaast draagt de betekenis. Een lege alt houdt hem uit de
    // voorleesvolgorde in plaats van er een bestandsnaam te laten voorlezen.
    'alt'           => '',
    'aria-hidden'   => 'true',
]) !!}

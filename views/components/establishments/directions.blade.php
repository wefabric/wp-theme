@include('components.link.opening', [
       'href' => $establishment->getAddress()->getGoogleMapsUrl(),
       'alt' => 'Adres op Google Maps',
       'class' => 'flex mb-2 no-underline'
   ])
    <i class="fa-solid fa-location-dot mr-4 ml-1 text-md pt-1"></i>
    <span class="inline-block pt-1 cursor-pointer">Routebeschrijving</span>
@include('components.link.closing')

@php
    $option = get_fields('option');

@endphp

@include('components.socials.list')

@if(isset($option['newsletter_footer'], $option['newsletter_footer']['show']) && $option['newsletter_footer']['show'] === true)
    <span class="font-head text-md pt-4 pb-2 pr-6 inline-block">
            {{ isset($option['newsletter_footer']['title']) ? $option['newsletter_footer']['title'] : 'Blijf op de hoogte' }}
        </span>
    <div>
        <div id="mc_embed_signup">
            @php
                $mailChimpSubscribeUrl = isset($option['newsletter_footer']['embed_subscribe_url']) ? $option['newsletter_footer']['embed_subscribe_url'] : '';
            @endphp

            @if($mailChimpSubscribeUrl)
                <form action="{{ $mailChimpSubscribeUrl }}" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll"></div>
                    <div class="flex">
                        <input type="email" value="" placeholder="E-mailadres" name="EMAIL" class="w-3/4 required email bg-white rounded-l-lg" id="mce-EMAIL">
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>
                        <div style="position: absolute; left: -5000px;" aria-hidden="true">
                            <input type="text" name="b_97458c1812b52842329db8e54_5af5026eaf" tabindex="-1" value="">
                        </div>
                        <div class="flex align-center">
                            <button type="submit" class="h-full w-10 bg-white text-primary-dark text-center text-sm hover:text-primary rounded-r-lg">
                                <i class="fa-solid fa-paper-plane "></i>
                                <span class="screen-reader-only">Aanmelden</span>
                            </button>
                            <input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
                        </div>

                    </div>
                </form>
                <div>
                    <p class="text-xs mt-2 italic">
                        Door je aan te melden ga je ermee akkoord dat we je maximaal 1x per maand marketingmails sturen. Alles in overeenstemming met onze <a href="{{ get_privacy_policy_url() }}" class="cursor-pointer hover:underline">privacyverklaring</a>. Je kunt je ook altijd weer afmelden voor deze e-mails.
                    </p>
                </div>
            @else
                <p>Nieuwsbrief inschrijving url niet toegevoegd aan de nieuwsbrief instellingen: Backend -> Site instellingen -> Nieuwsbrief</p>
            @endif
        </div>
    </div>
@endif

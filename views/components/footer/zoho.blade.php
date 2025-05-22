<form action="{{ $ZohoSubscribeUrl }}" method="post" id="zoho-embedded-subscribe-form" name="zoho-embedded-subscribe-form" class="zoho-form validate" target="_blank" enctype="multipart/form-data" accept-charset="UTF-8" novalidate>
    <div id="zoho_embed_signup_scroll"></div>
    <div class="form-layout flex">
        <input type="email" maxlength="255" name="Email" value="" fieldtype="9" placeholder="E-mailadres" class="required email bg-white rounded-l-lg" id="mce-EMAIL">
        <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
        </div>
        <div style="position: absolute; left: -5000px;" aria-hidden="true">
            <input type="text" name="b_97458c1812b52842329db8e54_5af5026eaf" tabindex="-1">
        </div>
        <div class="flex align-center">
            <button type="submit" class="zoho-submit h-full w-10 btn-white text-primary hover:text-white text-center text-sm rounded-r-lg">
                <i class="fa-solid fa-paper-plane "></i>
                <span class="screen-reader-only">Aanmelden</span>
            </button>
            <input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" aria-label="Submit button">
        </div>

    </div>
</form>
<div>
    <p class="agreement-text text-xs mt-2 italic text-{{ $text_color }}">
        @if ($text)
            {!! $text !!}
        @else
            Door je aan te melden ga je ermee akkoord dat we je maximaal 1x per maand marketingmails sturen. Alles in overeenstemming met onze
            @include('components.link.simple', [
                'href' => get_privacy_policy_url(),
                'text' => 'privacyverklaring',
            ])
            . Je kunt je ook altijd weer afmelden voor deze e-mails.
        @endif
    </p>
</div>
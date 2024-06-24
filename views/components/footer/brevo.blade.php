{{--<form action="{{ $brevoSubscribeUrl }}" method="post" id="brevo-embedded-subscribe-form" name="brevo-embedded-subscribe-form" class="brevo-form validate" target="_blank" novalidate>--}}
{{--	<div id="brevo_embed_signup_scroll"></div>--}}
{{--	<div class="flex">--}}
{{--		<input type="email" value="" placeholder="E-mailadres" name="email" class="required email bg-white rounded-l-lg" id="brevo-EMAIL">--}}
{{--		<div id="brevo-responses" class="clear">--}}
{{--			<div class="response" id="brevo-error-response" style="display:none"></div>--}}
{{--			<div class="response" id="brevo-success-response" style="display:none"></div>--}}
{{--		</div>--}}
{{--		<div style="position: absolute; left: -5000px;" aria-hidden="true">--}}
{{--			<input type="text" name="hidden_field" tabindex="-1" value="">--}}
{{--		</div>--}}
{{--		<div class="flex align-center">--}}
{{--			<button type="submit" class="brevo-submit h-full w-10 btn-white text-primary hover:text-white text-center text-sm rounded-r-lg">--}}
{{--				<i class="fa-solid fa-paper-plane"></i>--}}
{{--				<span class="screen-reader-only">Aanmelden</span>--}}
{{--			</button>--}}
{{--			<input type="submit" value="" name="subscribe" id="brevo-embedded-subscribe" aria-label="Submit button">--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</form>--}}


{!! do_shortcode('[sibwp_form id="' . $brevoID . '"]') !!}
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

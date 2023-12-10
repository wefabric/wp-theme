<form action="{{ $mailChimpSubscribeUrl }}" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="mailchimp-form validate" target="_blank" novalidate>
	<div id="mc_embed_signup_scroll"></div>
	<div class="flex">
		<input type="email" value="" placeholder="E-mailadres" name="EMAIL" class="required email bg-white rounded-l-lg" id="mce-EMAIL">
		<div id="mce-responses" class="clear">
			<div class="response" id="mce-error-response" style="display:none"></div>
			<div class="response" id="mce-success-response" style="display:none"></div>
		</div>
		<div style="position: absolute; left: -5000px;" aria-hidden="true">
			<input type="text" name="b_97458c1812b52842329db8e54_5af5026eaf" tabindex="-1" value="">
		</div>
		<div class="flex align-center">
			<button type="submit" class="h-full w-10 btn-white text-primary hover:text-white text-center text-sm rounded-r-lg">
				<i class="fa-solid fa-paper-plane "></i>
				<span class="screen-reader-only">Aanmelden</span>
			</button>
			<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe">
		</div>
	
	</div>
</form>
<div>
	<p class="text-xs mt-2 italic text-{{ $text_color }}">
		Door je aan te melden ga je ermee akkoord dat we je maximaal 1x per maand marketingmails sturen. Alles in overeenstemming met onze
		@include('components.link.simple', [
			'href' => get_privacy_policy_url(),
			'text' => 'privacyverklaring',
		])
		. Je kunt je ook altijd weer afmelden voor deze e-mails.
	</p>
</div>
<form action="{{ $mailChimpSubscribeUrl }}" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="mailchimp-form validate" target="_blank" novalidate>
	@php
		$urlComponents = parse_url($mailChimpSubscribeUrl);
		parse_str($urlComponents['query'] ?? '', $queryParams);
		$userId = $queryParams['u'] ?? '';
		$listId = $queryParams['id'] ?? '';
		$honeypotName = !empty($userId) && !empty($listId) ? "b_{$userId}_{$listId}" : 'b_honeypot';
	@endphp
	<div id="mc_embed_signup_scroll"></div>
	<div class="form-layout flex">
		<input type="email" value="" placeholder="E-mailadres" name="EMAIL" class="required email bg-white rounded-l-lg" id="mce-EMAIL">
		<div id="mce-responses" class="clear">
			<div class="response" id="mce-error-response" style="display:none"></div>
			<div class="response" id="mce-success-response" style="display:none"></div>
		</div>
		<div style="position: absolute; left: -5000px;" aria-hidden="true">
			<input type="text" name="{{ $honeypotName }}" tabindex="-1" value="">
			<input type="text" name="extra_hp" class="extra-hp" tabindex="-1" value="" autocomplete="off">
		</div>
		<div class="flex align-center">
			<button type="submit" class="mailchimp-submit h-full w-10 btn-white text-primary hover:text-white text-center text-sm rounded-r-lg">
				<i class="fa-solid fa-paper-plane "></i>
				<span class="screen-reader-only">Aanmelden</span>
			</button>
{{--			<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" aria-label="Submit button">--}}
		</div>
	
	</div>
</form>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var forms = document.querySelectorAll('.mailchimp-form');
		forms.forEach(function(form) {
			form.addEventListener('submit', function(e) {
				var extraHp = form.querySelector('.extra-hp').value;
				if (extraHp !== '') {
					e.preventDefault();
					console.warn('Spam detected');
					return false;
				}
			});
		});
	});
</script>
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
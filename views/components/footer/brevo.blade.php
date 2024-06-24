<div class="brevo-form">
	{!! do_shortcode('[sibwp_form id="' . $brevoID . '"]') !!}
</div>

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
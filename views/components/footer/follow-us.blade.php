@php
    $option = get_fields('option');
    if(!empty($option)) {
		if(array_key_exists('text_color', $option)) {
			$text_color = $option['text_color'];
		}
        if(array_key_exists('title_color', $option)) {
			$title_color = $option['title_color'];
		}
	}
@endphp

@include('components.socials.list', ['icon_class' => 'text-xl'])

@if(isset($option['newsletter_footer'], $option['newsletter_footer']['show']) && $option['newsletter_footer']['show'] === true)
	@php
		$title = !empty($option['newsletter_footer']['title']) ? $option['newsletter_footer']['title'] : 'Blijf op de hoogte';
        $text = $option['newsletter_footer']['newsletter_text'] ?? '';

		$mailChimpUrl = $option['newsletter_footer']['embed_subscribe_url'] ?? '';
        $zohoUrl = $option['newsletter_footer']['zoho_subscribe_url'] ?? '';
        $brevoID = $option['newsletter_footer']['brevo_subscribe_id'] ?? '';
	@endphp
	<span class="newsletter-title h5 text-{{ $title_color }} py-4 pr-6 inline-block">
		{{ $title }}
	</span>
    <div>
		@if(!empty($option['newsletter_footer']['newsletter_type']))


			@if($option['newsletter_footer']['newsletter_type'] == 'mailchimp' && $mailChimpUrl)
				<div id="mc_embed_signup" class="newsletter-signup">
					@include('components.footer.mailchimp', [
						'mailChimpSubscribeUrl' => $mailChimpUrl,
					])
				</div>
			@endif

			@if($option['newsletter_footer']['newsletter_type'] == 'zoho' && $zohoUrl)
				<div id="mc_embed_signup2" class="newsletter-signup">
					@include('components.footer.zoho', [
						'ZohoSubscribeUrl' => $zohoUrl,
					])
				</div>
			@endif

			@if($option['newsletter_footer']['newsletter_type'] == 'brevo')
				<div id="mc_embed_signup3" class="newsletter-signup">
					@include('components.footer.brevo', [
						'BrevoSubscribeID' => $brevoID,
					])
				</div>
			@endif

			@if($option['newsletter_footer']['newsletter_type'] == 'zijlstra')
				<div id="mc_embed_signup4" class="zijlstra-signup">
					@include('components.footer.zijlstra-newsletter', [

					])
				</div>
			@endif

                @if ($option['newsletter_footer']['newsletter_type'] === 'gravityform')
                    <div class="newsletter-signup">
                        {!! gravity_form(
                            $option['newsletter_footer']['newsletter_select_gravity_form'],
                            false,  // title
                            false,  // description
                            false,  // inactive
                            null,   // field values
                            true    // ajax
                        ) !!}
                    </div>
                @endif


        @endif
    </div>
@endif

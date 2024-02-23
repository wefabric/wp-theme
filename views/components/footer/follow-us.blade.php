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

		$url = $option['newsletter_footer']['embed_subscribe_url'] ?? '';
	@endphp
	<span class="newsletter-title h5 text-{{ $title_color }} py-4 pr-6 inline-block">
		{{ $title }}
	</span>
    <div>
        <div id="mc_embed_signup">
			@include('components.footer.mailchimp', [
				'mailChimpSubscribeUrl' => $url,
			])
        </div>
    </div>
@endif

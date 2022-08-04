@php
    $option = get_fields('option');
@endphp

@if(!empty($option) && array_key_exists('channels', $option))
    <div class="mb-8">
        @foreach($option['channels'] as $social)
            @include('components.buttons.icon', [
	            'href' => $social['url'],
	            'alt' => $social['name'],
	            'rel' => 'noopener',
	            'target' => '_blank',
	            'icon' => $social['icon'],
            ])
        @endforeach
    </div>
@endif
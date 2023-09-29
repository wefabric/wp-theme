@php
    $fields = get_fields($employee);

    $firstName = $fields['first_name'] ?? '';
    $lastName = $fields['last_name'] ?? '';
    $imageUrl = wp_get_attachment_url($fields['image']) ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];

    $function = $fields['function'] ?? '';
    $overviewText = $fields['overview_text'] ?? '';
    $socials = $fields['socials'] ?? [];

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght']??'': 'rounded-none';
@endphp

<div class="werknemer-item group h-full">
    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out ">
        <div class="h-[360px] overflow-hidden w-full rounded-{{ $borderRadius }}">
            <img src="{{ $imageUrl }}" alt="team"
                 class="w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-{{ $borderRadius }}">
        </div>
        <div class="w-full mt-5">
            <p class="font-bold text-lg">{{ $firstName }} {{ $lastName }}</p>
            @if (!empty($visibleElements) && in_array('function', $visibleElements))
                <p class="font-medium">{{ $function }}</p>
            @endif
            @if(!empty($visibleElements) && in_array('socials', $visibleElements) && !empty($socials))
                <div class="inline-flex gap-x-2">
                    @foreach ($socials as $social)
                        <a class="text-2xl transform ease-in-out duration-300 hover:scale-110 hover:text-primary"
                           href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
                            {!! $social['icon'] !!}
                        </a>
                    @endforeach
                </div>
            @endif
            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements))
                <p class="mt-3 mb-2">{{ $overviewText }}</p>
            @endif
        </div>
    </div>
</div>
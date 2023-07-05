@php
    $fields = get_fields($employee);

    $firstName = $fields['first_name'] ?? '';
    $lastName = $fields['last_name'] ?? '';
    $imageUrl = wp_get_attachment_url($fields['image']) ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];

    $function = $fields['function'] ?? '';
    $overviewText = $fields['overview_text'] ?? '';
    $socials = $fields['socials'] ?? [];
@endphp

<div class="werknemer-item group">
    <div class="h-full flex flex-col items-center border-2 border-gray-200 border-opacity-60 group-hover:-translate-y-4 duration-300 ease-in-out">
        <div class="h-60 lg:h-96 overflow-hidden w-full">
            <img src="{{ $imageUrl }}" alt="team" class="w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110">
        </div>
        <div class="w-full mt-4 p-3 md:p-4">
            <p class="font-bold text-lg">{{ $firstName }} {{ $lastName }}</p>
            @if (!empty($visibleElements) && in_array('function', $visibleElements))
                <p class="font-medium">{{ $function }}</p>
            @endif
            @if(!empty($visibleElements) && in_array('socials', $visibleElements) && !empty($socials))
                <div class="inline-flex gap-x-2">
                    @foreach ($socials as $social)
                        <a class="text-2xl transform ease-in-out duration-300 hover:scale-110 hover:text-primary" href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer">
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
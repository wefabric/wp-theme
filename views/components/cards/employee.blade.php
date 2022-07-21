@php
    if(! isset($employeeId)) {
        $employeeId = $item; //in case of slider
    }
    $fields = get_fields($employeeId);
    // $service = get_post($employeeId);
@endphp

<div class="hover:shadow-3xl max-w-md flex flex-col mx-auto">
    <div class="mx-auto mb-3 lg:h-80 lg:px-5 rounded-lg">
        @include('components.image', [
            'image_id' => $fields['image'],
            'class' => 'rounded-lg'
        ])
    </div>

    <div class="mx-auto mb-3">
        @include('components.headings.normal', [
            'type' => '3',
            'heading' => get_the_title($employeeId),
            'class' => 'text-center'
        ])
    </div>

    @if(isset($fields['function']) && $fields['function'])
        <div class="mx-auto mb-3">
            <p class="text-center text-base">{{ $fields['function'] }}</p>
        </div>
    @endif

    <div class="mx-auto mb-3">
        @if(!empty($fields['phonenumber']))
            @include('components.link.opening', [
                'href' => 'tel:'. $fields['phonenumber'],
                'alt' => 'Telefoonnummer'
            ])
                <span class="inline-block h-8 w-8 rounded-full mx-1 text-center
                    bg-black hover:bg-primary-dark text-white ">
                    <i class="fa-solid fa-phone text-sm align-top pt-1.5"></i>
                    <span class="screen-reader-only">Telefoonnummer</span>
                </span>
            @include('components.link.closing')
        @endif

        @if(!empty($fields['email']))
            @include('components.link.opening', [
                'href' => 'mailto:'. $fields['email'],
                'alt' => 'Emailadres'
            ])
                <span class="inline-block h-8 w-8 rounded-full mx-1 text-center
                    bg-black hover:bg-primary-dark text-white ">
                    <i class="fa-solid fa-envelope text-sm align-top pt-1.5"></i>
                    <span class="screen-reader-only">Emailadres</span>
                </span>
            @include('components.link.closing')
        @endif

        @if(!empty($fields['linkedin']))
            @include('components.link.opening', [
                'href' => $fields['linkedin'],
                'alt' => 'LinkedIn'
            ])
                <span class="inline-block h-8 w-8 rounded-full mx-1 text-center
                    bg-black hover:bg-primary-dark text-white ">
                    <i class="fa-brands fa-linkedin-in text-sm align-top pt-1.5"></i>
                    <span class="screen-reader-only">LinkedIn</span>
                </span>
            @include('components.link.closing')
        @endif
    </div>
</div>

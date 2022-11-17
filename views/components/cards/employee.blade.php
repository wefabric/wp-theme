@php
    if(! isset($employeeId)) {
        $employeeId = $item; //in case of slider
    }
    $fields = get_fields($employeeId);
    // $service = get_post($employeeId);
@endphp

<div class="hover:shadow-3xl max-w-md flex flex-col mx-auto {{ (isset($lg_hidden) && $lg_hidden) ? 'hidden lg:block' : '' }}">
    <div class="mx-auto mb-3 lg:h-80 lg:px-5 rounded-lg">
        @include('components.image', [
            'image_id' => $fields['image'],
			'size' => 'employee-thumbnail',
            'class' => 'rounded-lg',
        ])
    </div>

    <div class="mx-auto mb-3">
        @include('components.headings.normal', [
            'type' => 'h3',
            'heading' => get_the_title($employeeId),
            'class' => 'text-center text-xl',
        ])
    </div>

    @if(isset($fields['function']) && $fields['function'])
        <div class="mx-auto mb-3">
            @include('components.content', [
	            'content' => $fields['function'],
	            'class' => 'text-center ',
            ])
        </div>
    @endif

    <div class="mx-auto mb-3">
        @if(!empty($fields['phonenumber']))
			@include('components.buttons.icon', [
                'href' => 'tel:'. $fields['phonenumber'],
                'alt' => 'Telefoonnummer',
				'icon' => 'fa-solid fa-phone text-sm align-top pt-1.5',
				'size' => 'h-8 w-8',
				'colors' => 'btn-black text-white ',
				'a_class' => 'mx-1',
			])
		@endif

        @if(!empty($fields['email']))
			@include('components.buttons.icon', [
                'href' => 'mailto:'. $fields['email'],
                'alt' => 'Emailadres',
				'icon' => 'fa-solid fa-envelope text-sm align-top pt-1.5',
				'size' => 'h-8 w-8',
				'colors' => 'btn-black text-white ',
				'a_class' => 'mx-1',
			])
		@endif

        @if(!empty($fields['linkedin']))
			@include('components.buttons.icon', [
				'href' => $fields['linkedin'],
				'alt' => 'LinkedIn',
				'icon' => 'fa-brands fa-linkedin-in text-sm align-top pt-1.5',
				'size' => 'h-8 w-8',
				'colors' => 'btn-black text-white ',
				'a_class' => 'mx-1',
			])
        @endif
    </div>
</div>

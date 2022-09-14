@php
    $options = get_fields('option');
    $establishment = \Wefabric\WPEstablishments\Establishment::primary();
    $fields = collect(get_fields($establishment->post->ID));

	/*
    if($block->get('image') && $block->get('image')->get('position')) {
        //then what?
    }
	*/
@endphp
<div class="container mx-auto w-full lg:{{ $block->get('width') }} @if($block->get('show_address', false)) bg-{{ $block->get('bg_color') }} text-{{ $block->get('text_color') }} @endif pt-4 lg:pt-8">

    <div class="mt-6 mt-md-10 container position-relative z-index-2 mx-auto">
        <div class="relative @if($block->get('show_address', false)) md:grid md:grid-cols-2 gap-8 @endif" >
            <div class="@if($block->get('show_address', false) === false && $block->get('fill_color')) bg-{{ $block->get('fill_color') }} p-12 @endif @if($block->get('show_address', false) === false) lg:{{ $block->get('width_form') }} @endif bg-{{ str_replace('-color', '', $block->get('background_color', 'bg_color')) }} rounded-lg  text-{{ $block->get('text_color') }}">
                @if($block->get('show_separate_title'))
                    @include('components.headings.normal', [
                        'type' => 2,
                        'title' => $block->get('title'),
                        'class' => 'mb-8',
                        'text_color' => $block->get('text_color'),
                        'show_line' => $block->get('show_line')
                    ])
                @endif
                {!! $block->get('form') !!}

                @if($block->get('image') && $block->get('image')->get('image'))
                    <div class="absolute -right-2 md:-right-6 md:-bottom-16">
                        @include('components.image', [
                            'image_id' => $block->get('image')->get('image'),
                            'size' => 'full',
                            'class' => 'rounded-lg max-w-[150px] lg:max-w-none',
                        ])
                    </div>

                @endif
            </div>

            @if($block->get('show_address', false))
                <div class="offset-md-1 mt-12 md:mt-0 col-md-4 text-base">
                    <div class="widget widget-address">
                        <div class=" border-b-[1px] pb-4 border-[#DED8FF]">
                            <h2 class="text-lg  mb-6">{{ 'Contact' }}</h2>

                            <p class="text-sm leading-7">{{--Adress--}}
                                {{ $establishment->name }} <br/>
                                {{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }}
                                <br/>
                                {{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}
                            </p>

                            @include('components.establishments.directions')
                        </div>

                        @php $options = get_fields('option'); @endphp
                        @if(isset($options['channels']) && $options['channels'])
                            <div class="border-b-[1px] border-[#DED8FF]">
                                @include('components.socials.list')
                            </div>
                        @endif

                        @if($fields->get('contact_email') || $fields->get('contact_phone'))
                            <div class="border-b-[1px] py-6 border-[#DED8FF]">
                                @if($fields->get('contact_email'))
                                    <a href="mailto:{{ $fields->get('contact_email') }}" class="block group flex align-middle">
                                        <i class="fa-solid fa-envelope-open mr-4"></i>
                                        <span class="group-hover:underline self-center">{{ $fields->get('contact_email') }}</span>
                                    </a>
                                @endif
                                @if($fields->get('contact_phone'))
                                    <a href="tel:{{ $fields->get('contact_phone') }}" class=" block group flex align-middle @if($fields->get('contact_email')) mt-1 @endif">
                                        <i class="fa-solid fa-circle-phone mr-4"></i>
                                        <span class="group-hover:underline self-center">{{ $fields->get('contact_phone') }}</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                        @if($fields->get('kvk_number') || $fields->get('vat_id')  )
                            <div class="py-6">
                                @if($fields->get('kvk_number'))
                                    <span class="block text-sm leading-7 text-{{ $block->get('text_color') }}">
                                            {{ 'KVK: ' . $fields->get('kvk_number') }}
                                        </span>
                                @endif
                                @if($fields->get('vat_id'))
                                    <span class="block text-sm leading-7 text-{{ $block->get('text_color') }}">
                                            {{ 'BTW: ' . $fields->get('vat_id') }}
                                        </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            @endif
        </div>
    </div>

</div>
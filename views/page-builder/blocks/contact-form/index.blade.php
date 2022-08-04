@php
    $options = get_fields('option');
    $establishment = \Wefabric\WPEstablishments\Establishment::primary();
    $fields = collect(get_fields($establishment->post->ID));
@endphp
<div class="container mx-auto w-full lg:{{ $block->get('width') }} @if($block->get('show_address', false)) bg-{{ $block->get('bg_color') }} text-{{ $block->get('text_color') }} @endif pt-4 lg:pt-8">

    <div class="mt-6 mt-md-10 container position-relative z-index-2">
        <div class="@if($block->get('show_address', false)) md:grid md:grid-cols-2 @endif lg:w-5/6 xl:w-4/6 mx-auto" >
            <div class="bg-{{ str_replace('-color', '', $block->get('background_color', 'bg_color')) }} rounded-lg  text-{{ $block->get('text_color') }}">
                @if($block->get('show_separate_title'))
                    @include('components.headings.normal', [
                        'type' => 2,
                        'title' => $block->get('title'),
                        'text_color' => $block->get('text_color'),
                        'show_line' => $block->get('show_line')
                    ])
                @endif
                {!! $block->get('form') !!}
            </div>

            @if($block->get('show_address', false))
                <div class="mt-12 px-6 md:px-20 pb-12 mt-md-0 offset-md-1 col-md-4">
                    <div class="widget widget-address">
                        <div class="content border-b-[1px] pb-6 border-[#DED8FF]">
                            <h2 class="text-lg text-purple mb-6">{{ 'Contact' }}</h2>

                            <p class="text-sm leading-7">{{--Adress--}}
                                {{ $establishment->name }} <br/>
                                {{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }}
                                <br/>
                                {{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}
                            </p>

                            {{--Google maps link--}}
                            <a class="block align-middle flex mt-6" target="_blank" aria-label="Adres op Google Maps"
                               href="{{ $establishment->getAddress()->getGoogleMapsUrl() }}">
                                <i class="wi wi-route mr-4" style="width:24px; height: 24px;"></i>
                                <span class="text-purple-light cursor-pointer hover:underline inline-block pr-1">How to</span>
                                <span>get there</span>
                            </a>
                        </div>

                        @php $options = get_fields('option'); @endphp
                        @if(isset($options['channels']) && $options['channels'])
                            <div class="border-b-[1px] py-6 border-[#DED8FF]">
                                @include('components.socials.list')
                            </div>
                        @endif

                        <div class="border-b-[1px] py-6 border-[#DED8FF]">
                            @if($fields->get('contact_email'))
                                <a href="mailto:{{ $fields->get('contact_email') }}" class="text-purple-light block group flex align-middle">
                                    <i class="fa-solid fa-envelope-open text-md mr-4"></i>
                                    <span class="group-hover:underline self-center">{{ $fields->get('contact_email') }}</span>

                                </a>
                            @endif
                            @if($fields->get('contact_phone'))
                                <a href="tel:{{ $fields->get('contact_phone') }}" class="text-purple-light block group flex align-middle @if($fields->get('contact_email')) mt-1 @endif">
                                    <i class="fa-solid fa-circle-phone text-md mr-4"></i>
                                    <span class="group-hover:underline self-center">{{ $fields->get('contact_phone') }}</span>
                                </a>
                            @endif
                        </div>

                        <div class="py-6">
                            @if($fields->get('kvk_number'))
                                <span class="block text-sm leading-7 text-black">
                                        {{ 'KVK: ' . $fields->get('kvk_number') }}
                                    </span>
                            @endif
                            @if($fields->get('btw_number'))
                                <span class="block text-sm leading-7 text-black">
                                        {{ 'BTW: ' . $fields->get('btw_number') }}
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>

</div>

{{--<div>--}}
{{--    <label>--}}
{{--        Naam--}}
{{--        [text* your-name class:full-width class:rounded placeholder "Naam"]--}}
{{--    </label>--}}
{{--    <label>--}}
{{--        E-mailadres--}}
{{--        [email* your-email class:full-width placeholder "E-mailadres"]--}}
{{--    </label>--}}
{{--    <label>--}}
{{--        Telefoonnummer--}}
{{--        [text your-phone class:full-width placeholder "Telefoonnummer"]--}}
{{--    </label>--}}
{{--    <label>--}}
{{--        Bericht--}}
{{--        [textarea* your-message class:full-width placeholder "Bericht"]--}}
{{--    </label>--}}
{{--    [submit class:btn class:btn-primary class:pull-right "Verstuur"]--}}
{{--</div>--}}
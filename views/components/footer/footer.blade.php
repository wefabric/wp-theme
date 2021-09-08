@php
    $options = get_fields('option');
    $args = array(
        'posts_per_page'   => 1,
        'post_type'        => 'establishments',
    );
    $query = new WP_Query( $args );
    $establishment = $query->posts;

    if(isset($establishment[0])) {
     $fields = get_fields($establishment[0]->ID);
    }
@endphp

<div class="container mx-auto">
    <div class="grid grid-cols-2 lg:grid-cols-4 py-16 text-primary px-5">
        <div class="md:pr-16 mb-6">
            @if(isset($options['channels']) && $options['channels'])
                <h3 class="text-primary text-lg font-bold xl:text-xl mb-5">
                    @if($options['footer_socials_title'])
                        {{ $options['footer_socials_title'] }}
                    @endif
                </h3>

                <div class="mb-9">
                    @foreach($options['channels'] as $social)
                        <a href="{{ $social['url'] }}" target="_blank">
                            <i class="{{ $social['icon'] }} w-9 h-9 py-1 text-lg bg-primary text-white text-center hover:bg-secondary hover:text-white mr-3"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        <div class=" mb-6 col-span-2 md:col-span-1">
            <h3 class="text-primary text-lg xl:text-xl mb-5">
                @if(isset($options['contact_title']) && $options['contact_title'])
                    {{ $options['contact_title'] }}
                @endif
            </h3>

            <div class="text-sm mb-6 leading-7">
                @if(isset($fields['name']) && $fields['name'])<b>{{ $fields['name'] }}</b> <br>@endif
                @if(isset($fields['street'], $fields['house_number']) && $fields['street'] && $fields['house_number'])
                    {{ $fields['street'] }} {{ $fields['house_number'] }} {{ $fields['house_number_addition'] }} <br>
                @endif
                @if(isset($fields['postcode'], $fields['city']) && $fields['postcode'] && $fields['city'])
                    {{ $fields['postcode'] }} {{ $fields['city'] }}
                @endif
            </div>
        </div>

        <div class="mb-6 col-span-2">
            <h3 class="text-primary text-lg xl:text-xl mb-5">
                @if(isset($options['more_info_title']) && $options['more_info_title'])
                    {{ $options['more_info_title'] }}
                @endif
            </h3>

            <div class="text-sm leading-3">
                @if(isset($options['more_info_content']) && $options['more_info_content'])
                    {!! apply_filters('the_content', $options['more_info_content']) !!}
                @endif
            </div>

            <div class="text-sm leading-7">
                @if(isset($fields['common_phone']) && $fields['common_phone'])
                    <a href="tel:{{ $fields['common_phone'] }}" class="underline">
                        <i class="fas fa-phone mr-4"></i> {{ $fields['common_phone'] }}
                    </a><br>
                @endif
                @if(isset($fields['common_email']) && $fields['common_email'])
                    <a href="mailto:{{ $fields['common_email'] }}" class="underline">
                        <i class="fab fa-telegram-plane mr-4"></i> {{ $fields['common_email'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="site-info text-primary text-sm pb-6 mt-32 text-center">
        @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])
            {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'footer-logo']) !!}
        @endif

        @if(isset($options['terms_of_service']) && $options['terms_of_service'])
            <a href="{{ $options['terms_of_service'] }}">{{ __('Algemene voorwaarden', 'wefabric') }}</a>
            <span class="mx-4">/</span>
        @endif
        @if(isset($options['privacy_policy']) && $options['privacy_policy'])
            <a href="{{ $options['privacy_policy'] }}">{{ __('Privacy policy', 'wefabric') }}</a>
            <span class="mx-4">/</span>
        @endif
        @if(isset($options['cookie_policy']) && $options['cookie_policy'])
            <a href="{{ $options['cookie_policy'] }}">{{ __('Cookie beleid', 'wefabric') }}</a>
        @endif

        <div class="inline md:float-right text-sm">
            <span class="sep text-white"> ©{{ (new DateTime())->format('Y') }} {{ get_bloginfo('name') }} | </span>
            {!! sprintf(esc_html__('Ontwikkeld door %1$s .', THEME_TD), '<a href="https://wefabric.nl">Wefabric</a>') !!}
        </div>
    </div><!-- .site-info -->
</div>

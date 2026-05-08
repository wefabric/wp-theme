@php
    $option = get_fields('option');

    $showLogo    = $option['footer_top_show_logo'] ?? true;
    $showContact = $option['footer_top_show_contact'] ?? true;
    $showSocials = $option['footer_top_show_socials'] ?? true;
    $customData  = $option['footer_top_custom'] ?? [];

    $title_color = $option['title_color'] ?? '';

    $logoMap = [
        'logo_1'       => 'logo',
        'logo_2'       => 'logo_white',
        'logo_3'       => 'logo_3',
        'logo_1_small' => 'logo_1_small',
        'logo_2_small' => 'logo_2_small',
        'logo_3_small' => 'logo_3_small',
    ];
    $footerTopLogoKey    = $option['footer_top_logo'] ?? $option['footer_logo'] ?? 'logo_1';
    $footerLogoToDisplay = $logoMap[$footerTopLogoKey] ?? 'logo';

    $establishment = null;
    $footerEstablishments = $option['footer_establishments'] ?? [];
    if (!empty($footerEstablishments) && !empty($footerEstablishments[0])) {
        $estConfig = $footerEstablishments[0];
        if ($estConfig instanceof \Wefabric\WPEstablishments\Establishment) {
            $establishment = $estConfig;
        } elseif (is_array($estConfig) && array_key_exists('establishment', $estConfig)) {
            $establishment = new \Wefabric\WPEstablishments\Establishment($estConfig['establishment']);
        }
    }
    if (!$establishment) {
        $establishment = \Wefabric\WPEstablishments\Establishment::primary();
    }

    $customText           = $customData['text'] ?? '';
    $customButtonLink     = $customData['button_link'] ?? null;
    $customButtonColor    = $customData['button_color'] ?? 'primary-color';
    $customButtonStyle    = $customData['button_style'] ?? 'filled';
    $customButtonIcon     = $customData['button_icon'] ?? '';
    $customButtonDownload = $customData['button_download'] ?? false;
@endphp

<div class="footer-top custom-styling relative">
    <div class="container mx-auto px-8">
        <div class="footer-top-inner flex flex-col md:flex-row flex-wrap justify-between items-center gap-x-8 gap-y-4 py-6">

            @if($showLogo)
                <div class="footer-top-logo flex-shrink-0">
                    @if(isset(get_field('common', 'option')[$footerLogoToDisplay]) && $logoId = get_field('common', 'option')[$footerLogoToDisplay])
                        {!! wp_get_attachment_image($logoId, 'footer_logo', false, ['class' => 'footer-top-logo-image', 'loading' => 'eager', 'style' => 'height: 40px; width: auto; object-fit: contain;']) !!}
                    @endif
                </div>
            @endif

            @if($showContact && $establishment)
                <div class="footer-top-contact flex flex-col items-center sm:flex-row gap-x-6 gap-y-4">
                    @php $phone = $establishment->getContactPhone(); @endphp
                    @if($phone)
                        <a href="{{ $phone->uri() }}" class="footer-top-phone flex items-center gap-2">
                            <i class="fa-solid fa-phone text-{{ $title_color }}"></i>
                            <span>{{ get_bloginfo('language') === 'nl-NL' ? $phone->national() : $phone->international() }}</span>
                        </a>
                    @endif
                    @php $email = $establishment->getContactEmailAddress(); @endphp
                    @if($email)
                        <a href="mailto:{{ $email }}" class="footer-top-email flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-{{ $title_color }}"></i>
                            <span>{{ $email }}</span>
                        </a>
                    @endif
                </div>
            @endif

            @if(!empty($customText) || !empty($customButtonLink['url']))
                <div class="footer-top-custom flex flex-wrap items-center gap-4">
                    @if(!empty($customText))
                        <div class="footer-top-custom-text">{!! $customText !!}</div>
                    @endif
                    @if(!empty($customButtonLink['url']))
                        @include('components.buttons.default', [
                            'text'     => $customButtonLink['title'] ?? '',
                            'href'     => $customButtonLink['url'],
                            'alt'      => $customButtonLink['title'] ?? '',
                            'target'   => $customButtonLink['target'] ?? '_self',
                            'colors'   => 'btn-' . $customButtonColor . ' btn-' . $customButtonStyle,
                            'class'    => 'rounded-lg',
                            'icon'     => $customButtonIcon,
                            'download' => $customButtonDownload,
                        ])
                    @endif
                </div>
            @endif

            @if($showSocials && !empty($option['channels']))
                <div class="footer-top-socials flex items-center gap-3">
                    <span class="footer-top-socials-label">{{ __('Volg ons', 'wefabric') }}</span>
                    @foreach($option['channels'] as $social)
                        <a class="group footer-social social-{{ strtolower($social['name']) }}"
                           href="{{ $social['url'] }}" title="{{ $social['name'] }} pagina" target="_blank"
                           aria-label="Ga naar {{ $social['name'] }}">
                            <i class="{{ $social['icon'] }} transition-all group-hover:scale-110"></i>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

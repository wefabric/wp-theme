@php
    $options = get_fields('option');
    $footer_establishments = array_key_exists('footer_establishments', $options) ? $options['footer_establishments'] : [];

    if (empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [\Wefabric\WPEstablishments\Establishment::primary()];
    }
@endphp

<div class="secondary-navigation hidden lg:block w-full bg-{{ $options['secondary_menu_background_color'] ?? 'primary-color' }}">
    <div class="flex items-center justify-between flex-row container mx-auto h-12 px-4">
        @if(isset($options['secondary_menu_text']))
            <div class="font-normal text-sm text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">{{ $options['secondary_menu_text'] }}</div>
        @endif
        @if (!empty($options['secondary_menu_show_elements']))
            <div class="flex gap-4 text-sm h-full text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">
                @foreach($footer_establishments as $key => $establishment_config)
                    @php
                        $establishment = $establishment_config ? new \Wefabric\WPEstablishments\Establishment($establishment_config['establishment']) : null;
                        $phone = $establishment ? $establishment->getContactPhone() : '';
                        $email = $establishment ? $establishment->getContactEmailAddress() : '';
                    @endphp
                    @if (in_array('phone', $options['secondary_menu_show_elements']))
                        <a class="group flex items-center gap-2" href="tel:{{ $phone }} " title="Telefoonnummer">
                            <i class="p-1.5 flex text-md justify-center items-center  rotate-[270deg] rounded-lg fa-solid fa-phone"></i>
                            <span class="align-middle ">{{ $phone }}</span>
                        </a>
                    @endif

                    <a class="group flex items-center gap-2 bg-primary hover:bg-primary-light rounded-b-md p-4 h-5/6" target="_blank"
                       href="https://kms3.zijlstraberoepskleding.nl/u/inloggen" title="Inloggen KMS">
                        <i class="p-1.5 flex text-md justify-center items-center font-dyno rounded-lg fa-solid fa-user"></i>
                        <span class="align-middle text-white">Inloggen KMS</span>
                    </a>

                    @if (in_array('email', $options['secondary_menu_show_elements']))
                        <a class="group flex items-center gap-2" href="mailto:{{ $email }}" title="E-mailadres">
                            <i class="p-1.5 flex justify-center items-center  rounded-lg fa-solid fa-envelope"></i>
                            <span class="align-middle">{{ $email }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
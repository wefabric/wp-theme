@php
    $option = get_fields('option');

    if(!empty($option)) {
        if(array_key_exists('footer_secondary_establishments', $option)) {
            $footer_establishments = $option['footer_secondary_establishments'];
        }
    }

    if(empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [];
        $footer_establishments[] = \Wefabric\WPEstablishments\Establishment::primary();
    }

     if(array_key_exists('title_color', $option)) {
            $title_color = $option['title_color'];
        }
@endphp


<div class="block relative">
    <div class="swiper establishments-swiper py-8">
        <div class="swiper-wrapper">
            @foreach($footer_establishments as $key => $establishment_config)
                <div class="swiper-slide h-auto">
                    @php
                        /* @var WP_Post $establishment_config */
                        $establishment = null;
                        if ($establishment_config instanceof \Wefabric\WPEstablishments\Establishment) {
                            $establishment = $establishment_config;
                        } elseif (is_array($establishment_config) && array_key_exists('establishment', $establishment_config)) {
                            $establishment = new \Wefabric\WPEstablishments\Establishment($establishment_config['establishment']);
                        }

                        $establishment_title = $establishment->post->post_title;
                    @endphp

                    <div class="footer-address">
                        @if($establishment)
                            <p class="establishment-title leading-8">
                                {!! $establishment_title !!}
                            </p>
                            <p class="establishment-address leading-8">
                                {{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }} <br/>
                                {{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}
                            </p>

                            @if($phone = $establishment->getContactPhone())
                                @include('components.link.opening', [
                                    'href' => $phone->uri(), //comes with a 'tel:' already
                                    'alt' => 'Telefoonnummer',
                                    'class' => 'phone-text flex'
                                ])
                                <i class="fa-solid fa-phone mr-4 text-{{ $title_color }} text-md pt-1"></i>
                                <span class="inline-block pt-1">{{ $phone->international() }}</span>
                                @include('components.link.closing')
                            @endif

                            @if($email = $establishment->getContactEmailAddress())
                                @include('components.link.opening', [
                                    'href' => 'mailto:'. $email,
                                    'alt' => 'E-mailadres',
                                    'class' => 'email-text flex'
                                ])
                                <i class="fa-solid fa-envelope text-{{ $title_color }} mr-4 text-md pt-1"></i>
                                <span class="inline-block pt-1">{{ $email }}</span>
                                @include('components.link.closing')
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="xl:hidden swiper-pagination"></div>
    </div>
</div>


<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var establishmentsSwiper = new Swiper(".establishments-swiper", {
            spaceBetween: 20,
            centeredSlides: false,
            slidesPerView: 5,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            breakpoints: {
                0: {
                    loop: true,
                    slidesPerView: 1,
                },
                768: {
                    loop: true,
                    slidesPerView: 2,
                },
                768: {
                    loop: true,
                    slidesPerView: 3,
                },
                1280: {
                    loop: false,
                    slidesPerView: 5,
                },
            }
        });
    });
</script>

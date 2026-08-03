@php
    $sliderId = 'imageUspSwiper-' . $randomNumber;
    $hasMultiple = count($usps) > 1;
@endphp

<div class="image-usp-overlay absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 z-20 w-3/4">
    <div class="slider image-usp-swiper-{{ $randomNumber }} block relative">
        <div class="swiper {{ $sliderId }}">
            <div class="swiper-wrapper">
                @foreach ($usps as $usp)
                    @if ($usp['uspTitle'] || $usp['uspText'])
                        <div class="swiper-slide h-auto">
                            <div class="image-usp-item flex items-center justify-center gap-x-2 text-white px-6 py-4">
                                @if ($usp['uspIcon'])
                                    @php
                                        $iconData = json_decode($usp['uspIcon'], true);
                                        $iconClass = 'fa-' . ($iconData['style'] ?? 'solid') . ' fa-' . ($iconData['id'] ?? '');
                                    @endphp
                                    <span class="image-usp-icon flex items-center justify-center w-12 h-12 shrink-0 text-cta text-3xl">
                                        <i class="fa {{ $iconClass }}" aria-hidden="true"></i>
                                    </span>
                                @endif
                                <div class="image-usp-content flex items-center justify-center gap-x-2 flex-wrap text-center">
                                    @if ($usp['uspTitle'])
                                        <div class="image-usp-title font-bold text-2xl whitespace-nowrap">{!! $usp['uspTitle'] !!}</div>
                                    @endif
                                    @if ($usp['uspText'])
                                        <div class="image-usp-text text-sm opacity-90">{!! $usp['uspText'] !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        new Swiper(".{{ $sliderId }}", {
            slidesPerView: 1,
            loop: {{ $hasMultiple ? 'true' : 'false' }},
            @if ($hasMultiple)
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
            @endif
        });
    });
</script>

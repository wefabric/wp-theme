@php
    use Theme\Blocks\Usp\UspBlock;
    $uspBlock = new UspBlock($block);
    $randomNumber = rand(0, 1000);
@endphp

<section id="@if($uspBlock->customBlockId){{ $uspBlock->customBlockId }}@else{{ 'usps' }}@endif"
         class="block-usps relative usp-{{ $randomNumber }}-custom-padding usp-{{ $randomNumber }}-custom-margin layout-{{ $uspBlock->uspLayout }} bg-{{ $uspBlock->backgroundColor }} {{ $uspBlock->customBlockClasses }} {{ $uspBlock->hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($uspBlock->backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($uspBlock->backgroundImageParallax) background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($uspBlock->backgroundImageId) }}">
    @if($uspBlock->swiperOutContainer)
        <div class="overflow-hidden">
    @endif
    @if ($uspBlock->overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $uspBlock->overlayColor }} opacity-{{ $uspBlock->overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $uspBlock->fullScreenClass }}">
        <div class="custom-width {{ $uspBlock->blockClass }} {{ $uspBlock->textClass }} mx-auto">
            <div class="content-section">
                @if ($uspBlock->subTitle)
                    <span class="subtitle block mb-2 text-{{ $uspBlock->subTitleColor }} {{ $uspBlock->textClass }}">
                        @if ($uspBlock->subtitleIcon)
                            <i class="subtitle-icon text-{{ $uspBlock->subtitleIconColor }} fa-{{ $uspBlock->subtitleIcon['style'] }} fa-{{ $uspBlock->subtitleIcon['id'] }} mr-1"></i>
                        @endif
                        {!! $uspBlock->subTitle !!}
                    </span>
                @endif
                @if ($uspBlock->title)
                    <h2 class="title mb-4 text-{{ $uspBlock->titleColor }} container mx-auto @if($uspBlock->blockWidth == 'fullscreen') px-8 @endif">{!! $uspBlock->title !!}</h2>
                @endif
                @if ($uspBlock->text)
                    @include('components.content', [
                        'content' => apply_filters('the_content', $uspBlock->text),
                        'class' => 'container mx-auto mb-4 text-' . $uspBlock->textColor . ($uspBlock->blockWidth == 'fullscreen' ? ' px-8' : '')
                    ])
                @endif
                @if ($uspBlock->button1Text && $uspBlock->button1Link && $uspBlock->buttonPosition === 'top')
                    <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $uspBlock->textClass }} container mx-auto @if($uspBlock->blockWidth == 'fullscreen') px-8 @endif">
                        @include('components.buttons.default', [
                            'text' => $uspBlock->button1Text,
                            'href' => $uspBlock->button1Link,
                            'alt' => $uspBlock->button1Text,
                            'colors' => 'btn-' . $uspBlock->button1Color . ' btn-' . $uspBlock->button1Style,
                            'class' => 'rounded-lg',
                            'target' => $uspBlock->button1Target,
                            'icon' => $uspBlock->button1Icon,
                            'download' => $uspBlock->button1Download,
                        ])
                        @if ($uspBlock->button2Text && $uspBlock->button2Link)
                            @include('components.buttons.default', [
                                'text' => $uspBlock->button2Text,
                                'href' => $uspBlock->button2Link,
                                'alt' => $uspBlock->button2Text,
                                'colors' => 'btn-' . $uspBlock->button2Color . ' btn-' . $uspBlock->button2Style,
                                'class' => 'rounded-lg',
                                'target' => $uspBlock->button2Target,
                                'icon' => $uspBlock->button2Icon,
                                'download' => $uspBlock->button2Download,
                            ])
                        @endif
                    </div>
                @endif
            </div>
            @if ($uspBlock->usps)
                @include('components.usps.list', ['usps' => $uspBlock->usps, 'uspBlock' => $uspBlock])
            @endif
            @if ($uspBlock->button1Text && $uspBlock->button1Link && $uspBlock->buttonPosition === 'bottom')
                <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $uspBlock->textClass }} container mx-auto @if($uspBlock->blockWidth == 'fullscreen') px-8 @endif">
                    @include('components.buttons.default', [
                        'text' => $uspBlock->button1Text,
                        'href' => $uspBlock->button1Link,
                        'alt' => $uspBlock->button1Text,
                        'colors' => 'btn-' . $uspBlock->button1Color . ' btn-' . $uspBlock->button1Style,
                        'class' => 'rounded-lg',
                        'target' => $uspBlock->button1Target,
                        'icon' => $uspBlock->button1Icon,
                        'download' => $uspBlock->button1Download,
                    ])
                    @if ($uspBlock->button2Text && $uspBlock->button2Link)
                        @include('components.buttons.default', [
                            'text' => $uspBlock->button2Text,
                            'href' => $uspBlock->button2Link,
                            'alt' => $uspBlock->button2Text,
                            'colors' => 'btn-' . $uspBlock->button2Color . ' btn-' . $uspBlock->button2Style,
                            'class' => 'rounded-lg',
                            'target' => $uspBlock->button2Target,
                            'icon' => $uspBlock->button2Icon,
                            'download' => $uspBlock->button2Download,
                        ])
                    @endif
                </div>
            @endif
        </div>
    </div>
    @if($uspBlock->swiperOutContainer)
        </div>
    @endif
</section>

<style>
    .usp-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($uspBlock->mobilePaddingTop) padding-top: {{ $uspBlock->mobilePaddingTop }}px; @endif
            @if($uspBlock->mobilePaddingRight) padding-right: {{ $uspBlock->mobilePaddingRight }}px; @endif
            @if($uspBlock->mobilePaddingBottom) padding-bottom: {{ $uspBlock->mobilePaddingBottom }}px; @endif
            @if($uspBlock->mobilePaddingLeft) padding-left: {{ $uspBlock->mobilePaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($uspBlock->tabletPaddingTop) padding-top: {{ $uspBlock->tabletPaddingTop }}px; @endif
            @if($uspBlock->tabletPaddingRight) padding-right: {{ $uspBlock->tabletPaddingRight }}px; @endif
            @if($uspBlock->tabletPaddingBottom) padding-bottom: {{ $uspBlock->tabletPaddingBottom }}px; @endif
            @if($uspBlock->tabletPaddingLeft) padding-left: {{ $uspBlock->tabletPaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($uspBlock->desktopPaddingTop) padding-top: {{ $uspBlock->desktopPaddingTop }}px; @endif
            @if($uspBlock->desktopPaddingRight) padding-right: {{ $uspBlock->desktopPaddingRight }}px; @endif
            @if($uspBlock->desktopPaddingBottom) padding-bottom: {{ $uspBlock->desktopPaddingBottom }}px; @endif
            @if($uspBlock->desktopPaddingLeft) padding-left: {{ $uspBlock->desktopPaddingLeft }}px; @endif
        }
    }

    .usp-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($uspBlock->mobileMarginTop) margin-top: {{ $uspBlock->mobileMarginTop }}px; @endif
            @if($uspBlock->mobileMarginRight) margin-right: {{ $uspBlock->mobileMarginRight }}px; @endif
            @if($uspBlock->mobileMarginBottom) margin-bottom: {{ $uspBlock->mobileMarginBottom }}px; @endif
            @if($uspBlock->mobileMarginLeft) margin-left: {{ $uspBlock->mobileMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($uspBlock->tabletMarginTop) margin-top: {{ $uspBlock->tabletMarginTop }}px; @endif
            @if($uspBlock->tabletMarginRight) margin-right: {{ $uspBlock->tabletMarginRight }}px; @endif
            @if($uspBlock->tabletMarginBottom) margin-bottom: {{ $uspBlock->tabletMarginBottom }}px; @endif
            @if($uspBlock->tabletMarginLeft) margin-left: {{ $uspBlock->tabletMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($uspBlock->desktopMarginTop) margin-top: {{ $uspBlock->desktopMarginTop }}px; @endif
            @if($uspBlock->desktopMarginRight) margin-right: {{ $uspBlock->desktopMarginRight }}px; @endif
            @if($uspBlock->desktopMarginBottom) margin-bottom: {{ $uspBlock->desktopMarginBottom }}px; @endif
            @if($uspBlock->desktopMarginLeft) margin-left: {{ $uspBlock->desktopMarginLeft }}px; @endif
        }
    }

    .usp-hidden {
        opacity: 0;
    }

    .swiper-slide-duplicate .usp-hidden {
        animation: flyIn 0.6s ease-out forwards !important;
    }

    .usp-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

@if ($uspBlock->flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const uspItems = document.querySelectorAll('.USP-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const uspItem = entry.target;

                        setTimeout(() => {
                            if (uspItem.classList.contains('usp-hidden')) {
                                uspItem.classList.add('usp-animated');
                                uspItem.classList.remove('usp-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(uspItem);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            uspItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endif

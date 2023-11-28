@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // FAQ
    $faqId = $block['data']['faq_group'] ?? '';
    $questionsAndAnswers = get_field('faq', $faqId);
    $faqBackgroundColor = $block['data']['faq_background_color'] ?? 'default-color';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';
@endphp

<section id="faq" class="relative bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="mx-auto {{ $blockClass }} {{ $titleClass }}">
            <div class="faq-drawer container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">
                @if ($title)
                    <h2 class="mb-8 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                @if ($questionsAndAnswers)
                    @foreach ($questionsAndAnswers as $key => $faq)
                        <div class="mb-2 text-left text-{{ $textColor }}">
                            <input class="faq-drawer__trigger mb-4" id="faq-drawer-{{$key}}" type="checkbox"/>
                            <label class="faq-drawer__title relative block cursor-pointer text-md font-bold p-10 bg-{{ $faqBackgroundColor }}"
                                   for="faq-drawer-{{$key}}">{{ $faq['question_and_answer']['question'] }}</label>
                            <div class="faq-drawer__content-wrapper">
                                <div class="faq-drawer__content px-10 pb-8 bg-{{ $faqBackgroundColor }}">
                                    <div class="text-base ">{!! apply_filters('the_content', $faq['question_and_answer']['answer']) !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
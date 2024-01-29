@php
    $title = $custom_modal['title'] ?? '';
    $titleColor = $custom_modal['title_color'] ?? 'black';
    $text = $custom_modal['text'] ?? '';
    $textColor = $custom_modal['text_color'] ?? 'black';

    // Buttons
    $button1Text = $custom_modal['button']['button_1']['title'] ?? '';
    $button1Link = $custom_modal['button']['button_1']['url'] ?? '';
    $button1Target = $custom_modal['button']['button_1']['target'] ?? '_self';
    $button1Color = $custom_modal['button']['button_1_color'] ?? '';
    $button1Style = $custom_modal['button']['button_1_style'] ?? '';
    $button2Text = $custom_modal['button']['button_2']['title'] ?? '';
    $button2Link = $custom_modal['button']['button_2']['url'] ?? '';
    $button2Target = $custom_modal['button']['button_2']['target'] ?? '_self';
    $button2Color = $custom_modal['button']['button_2_color'] ?? '';
    $button2Style = $custom_modal['button']['button_2_style'] ?? '';

    $imageID = $custom_modal['image'] ?? '';
    $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);

    $textPosition = $custom_modal['text_position'] ?? '';
    $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center'];
    $textClass = $titleClassMap[$textPosition] ?? '';

    $modalBackground = $custom_modal['background_color'] ?? 'white';
@endphp

<div id="theme-modal" style="z-index: 99999;" class="fixed top-0 left-0 w-full h-full">

    <div class="theme-modal-close w-screen h-screen bg-black opacity-50"></div>

    <div class="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 container w-5/6 md:w-2/3 xl:w-1/2 2xl:w-1/3 h-fit bg-{{ $modalBackground }} mx-auto rounded-lg">

        {{--        Modal header--}}
        <div class="p-5 border-b">
            <h2 class="text-xl font-semibold {{ $textClass }} text-{{ $titleColor }}">
                {{ $title }}
            </h2>
        </div>

        <button type="button"
                class="absolute top-[10px] right-[10px] theme-modal-close text-gray-400 hover:text-gray-700 text-lg w-8 h-8 inline-flex justify-center items-center"
                data-modal-hide="default-modal">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
        </button>

        {{--        Modal content--}}
        <div class="px-5 py-12 {{ $textClass }}">
            <div class="flex flex-col md:flex-row items-center gap-8">
            @if ($text)
                <div class="order-1 md:order-0 w-full md:w-2/3">
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'text-' . $textColor])


                    @if (($button1Text) && ($button1Link))
                        <div class="{{ $textClass }} w-full flex flex-col sm:flex-row gap-y-2 gap-x-4 mt-4 md:mt-8">
                            @include('components.buttons.default', [
                               'text' => $button1Text,
                               'href' => $button1Link,
                               'alt' => $button1Text,
                               'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                               'class' => 'rounded-lg',
                               'target' => $button1Target,
                           ])
                            @if (($button2Text) && ($button2Link))
                                @include('components.buttons.default', [
                                   'text' => $button2Text,
                                   'href' => $button2Link,
                                   'alt' => $button2Text,
                                   'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                                   'class' => 'rounded-lg',
                                   'target' => $button2Target,
                               ])
                            @endif
                        </div>
                    @endif

                </div>


            @endif


            @if ($imageID)
                <div class="order-0 md:order-1 w-full md:w-1/3">
                    @include('components.image', [
                       'image_id' => $imageID,
                       'size' => 'full',
                       'object_fit' => 'contain',
                       'img_class' => 'w-full max-h-[180px] h-auto object-contain rounded-',
                       'alt' => $imageAlt
                   ])
                </div>
            @endif
            </div>
        </div>

    </div>
</div>
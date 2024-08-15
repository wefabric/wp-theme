@php
     // Content
     $title = $block['data']['title'] ?? '';
     $subTitle = $block['data']['subtitle'] ?? '';
     $titleColor = $block['data']['title_color'] ?? '';
     $text = $block['data']['text'] ?? '';
     $textColor = $block['data']['text_color'] ?? '';
     $form = $block['data']['form'] ?? '';

         // Buttons
         $button1Text = $block['data']['button_button_1']['title'] ?? '';
         $button1Link = $block['data']['button_button_1']['url'] ?? '';
         $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
         $button1Color = $block['data']['button_button_1_color'] ?? '';
         $button1Style = $block['data']['button_button_1_style'] ?? '';
         $button2Text = $block['data']['button_button_2']['title'] ?? '';
         $button2Link = $block['data']['button_button_2']['url'] ?? '';
         $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
         $button2Color = $block['data']['button_button_2_color'] ?? '';
         $button2Style = $block['data']['button_button_2_style'] ?? '';

         $textPosition = $block['data']['text_position'] ?? '';
         $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end'];
         $textClass = $titleClassMap[$textPosition] ?? '';


     // Modal
     $layout = $block['data']['layout'] ?? 'box';
     $boxPosition = $block['data']['box_position'] ?? 'bottom_right';

     $layoutClass = '';

     if ($layout == 'box') {
         switch ($boxPosition) {
             case 'bottom_left':
                 $layoutClass = 'box-classes left-[20px] mr-[20px] bottom-[20px] lg:max-w-[500px]';
                 break;
             case 'bottom_right':
                 $layoutClass = 'box-classes right-[20px] ml-[20px] bottom-[20px] lg:max-w-[500px]';
                 break;
             case 'top_left':
                 $layoutClass = 'box-classes left-[20px] mr-[20px] top-[20px] lg:max-w-[500px]';
                 break;
             case 'top_right':
                 $layoutClass = 'box-classes right-[20px] ml-[20px] top-[20px] lg:max-w-[500px]';
                 break;
             default:
                 $layoutClass = 'box-classes';
                 break;
         }
     } elseif ($layout == 'banner') {
         $layoutClass = 'banner-classes';
     } elseif ($layout == 'popup') {
        $layoutClass = 'popup-classes top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full sm:w-3/4 md:w-2/3 xl:w-1/2 max-w-[1000px]';
     }

     $modalDelay = $block['data']['modal_delay'] ?? 0;
     $backdrop = $block['data']['backdrop'] ?? false;


     // Blokinstellingen
     $backgroundColor = $block['data']['background_color'] ?? 'default-color';
     $backgroundImageId = $block['data']['background_image'] ?? '';
     $overlayEnabled = $block['data']['overlay_image'] ?? false;
     $overlayColor = $block['data']['overlay_color'] ?? '';
     $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

     $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
     $hideBlock = $block['data']['hide_block'] ?? false;

     $randomNumber = rand(0, 1000);
@endphp

@if ($backdrop)
    <div id="backdrop-{{ $randomNumber }}" class="close-modal backdrop fixed inset-0 bg-black @if($modalDelay !== 0) bg-opacity-0 @else opacity-50 @endif transition-all duration-300 ease-in-out" style="z-index: 9999"></div>
@endif

<section id="modal" class="fixed @if($modalDelay !== 0) opacity-0 @else opacity-100 @endif shadow-2xl transition-all duration-300 ease-in-out {{ $layoutClass }} modal-{{ $randomNumber }} bg-{{ $backgroundColor }} rounded-[32px] {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="z-index: 10000; background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }};">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 rounded-[32px] bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="close-modal z-20 absolute top-[10px] right-[18px] group cursor-pointer">
        <i class="fa-solid fa-xmark text-xl hover:text-primary cursor-pointer group-hover:scale-125 transition-all duration-300 ease-in-out group-hover:rotate-90"></i>
    </div>

    <div class="custom-styling relative z-10 px-8 py-8">
        <div class="mx-auto {{ $textClass }}">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
            @endif
            @if ($title)
                <div class="title h3 mb-4 text-{{ $titleColor }}">{!! $title !!}</div>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'text-' . $textColor
                ])
            @endif
            @if (($button1Text) && ($button1Link))
                <div class="{{ $textClass }} buttons w-full flex flex-wrap gap-4 mt-4 md:mt-8">
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
            @if ($form)
                {!! gravity_form($form, false) ; !!}
            @endif
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.querySelector('.modal-{{ $randomNumber }}');
        var closeModalButtons = document.querySelectorAll('.close-modal');
        var backdrop = document.getElementById('backdrop-{{ $randomNumber }}');
        var showDelay = {{ $modalDelay }} * 1000;
        var transitionDuration = 300;

        // Initially hide both modal and backdrop
        modal.style.display = 'none';
        backdrop.style.display = 'none';

        // Function to show both modal and backdrop
        function showModal() {
            if (backdrop) {
                backdrop.style.display = 'block';
                setTimeout(function() {
                    backdrop.classList.remove('bg-opacity-0');
                    backdrop.classList.add('bg-opacity-50');
                }, 0); // Apply opacity change immediately
            }

            modal.style.display = 'block';
            setTimeout(function() {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
            }, 0); // Apply opacity change immediately
        }

        // Function to hide both modal and backdrop
        function closeModal() {
            modal.classList.add('opacity-0');
            modal.classList.remove('opacity-100');
            if (backdrop) {
                backdrop.classList.add('bg-opacity-0');
                backdrop.classList.remove('bg-opacity-50');
                // Wait for the fade-out transition to complete before hiding both modal and backdrop
                setTimeout(function() {
                    backdrop.style.display = 'none';
                    modal.style.display = 'none';
                }, transitionDuration);
            }
        }

        // Show modal and backdrop after showDelay - transitionDuration
        setTimeout(showModal, showDelay - transitionDuration);

        // Close modal on close button click
        closeModalButtons.forEach(function(button) {
            button.addEventListener('click', closeModal);
        });

        // Close modal when backdrop is clicked
        if (backdrop) {
            backdrop.addEventListener('click', closeModal);
        }
    });
</script>


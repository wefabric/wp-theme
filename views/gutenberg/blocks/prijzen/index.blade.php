@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';


    // Show activities
    $displayType = $block['data']['display_type'];

    if ($displayType == 'show_all') {
        $args = [
        'posts_per_page' => -1,
        'post_type' => 'activities',
        ];

        $query = new WP_Query($args);
        $activities = wp_list_pluck($query->posts, 'ID');
    }

    elseif ($displayType == 'show_specific') {
        $activities = $block['data']['show_specific_activity'];
            if (!is_array($activities) || empty($activities)) {
                $activities = [];
            }
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght']??'': 'rounded-none';
@endphp

<section id="prijspakketten" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            <h2 class="text-{{ $titleColor }} container mx-auto mb-8 lg:mb-20 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{{ $title }}</h2>
{{--            @include('components.activities.list', ['activities' => $activities])--}}
        </div>
    </div>
</section>



{{--<section class="text-gray-600 body-font overflow-hidden">--}}
{{--    <div class="container px-5 py-24 mx-auto">--}}
{{--        <div class="flex flex-wrap -m-4">--}}
{{--            <div class="p-4 xl:w-1/4 md:w-1/2 w-full">--}}
{{--                <div class="h-full p-6 rounded-lg border-2 border-gray-300 flex flex-col relative overflow-hidden">--}}
{{--                    <h2 class="text-sm tracking-widest title-font mb-1 font-medium">START</h2>--}}
{{--                    <h1 class="text-5xl text-gray-900 pb-4 mb-4 border-b border-gray-200 leading-none">Free</h1>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Vexillologist pitchfork--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Tumeric plaid portland--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-6">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Mixtape chillwave tumeric--}}
{{--                    </p>--}}
{{--                    <button class="flex items-center mt-auto text-white bg-gray-400 border-0 py-2 px-4 w-full focus:outline-none hover:bg-gray-500 rounded">Button--}}
{{--                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">--}}
{{--                            <path d="M5 12h14M12 5l7 7-7 7"></path>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                    <p class="text-xs text-gray-500 mt-3">Literally you probably haven't heard of them jean shorts.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="p-4 xl:w-1/4 md:w-1/2 w-full">--}}
{{--                <div class="h-full p-6 rounded-lg border-2 border-indigo-500 flex flex-col relative overflow-hidden">--}}
{{--                    <span class="bg-indigo-500 text-white px-3 py-1 tracking-widest text-xs absolute right-0 top-0 rounded-bl">POPULAR</span>--}}
{{--                    <h2 class="text-sm tracking-widest title-font mb-1 font-medium">PRO</h2>--}}
{{--                    <h1 class="text-5xl text-gray-900 leading-none flex items-center pb-4 mb-4 border-b border-gray-200">--}}
{{--                        <span>$38</span>--}}
{{--                        <span class="text-lg ml-1 font-normal text-gray-500">/mo</span>--}}
{{--                    </h1>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Vexillologist pitchfork--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Tumeric plaid portland--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Hexagon neutra unicorn--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-6">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Mixtape chillwave tumeric--}}
{{--                    </p>--}}
{{--                    <button class="flex items-center mt-auto text-white bg-indigo-500 border-0 py-2 px-4 w-full focus:outline-none hover:bg-indigo-600 rounded">Button--}}
{{--                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">--}}
{{--                            <path d="M5 12h14M12 5l7 7-7 7"></path>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                    <p class="text-xs text-gray-500 mt-3">Literally you probably haven't heard of them jean shorts.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="p-4 xl:w-1/4 md:w-1/2 w-full">--}}
{{--                <div class="h-full p-6 rounded-lg border-2 border-gray-300 flex flex-col relative overflow-hidden">--}}
{{--                    <h2 class="text-sm tracking-widest title-font mb-1 font-medium">BUSINESS</h2>--}}
{{--                    <h1 class="text-5xl text-gray-900 leading-none flex items-center pb-4 mb-4 border-b border-gray-200">--}}
{{--                        <span>$56</span>--}}
{{--                        <span class="text-lg ml-1 font-normal text-gray-500">/mo</span>--}}
{{--                    </h1>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Vexillologist pitchfork--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Tumeric plaid portland--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Hexagon neutra unicorn--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Vexillologist pitchfork--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-6">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Mixtape chillwave tumeric--}}
{{--                    </p>--}}
{{--                    <button class="flex items-center mt-auto text-white bg-gray-400 border-0 py-2 px-4 w-full focus:outline-none hover:bg-gray-500 rounded">Button--}}
{{--                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">--}}
{{--                            <path d="M5 12h14M12 5l7 7-7 7"></path>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                    <p class="text-xs text-gray-500 mt-3">Literally you probably haven't heard of them jean shorts.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="p-4 xl:w-1/4 md:w-1/2 w-full">--}}
{{--                <div class="h-full p-6 rounded-lg border-2 border-gray-300 flex flex-col relative overflow-hidden">--}}
{{--                    <h2 class="text-sm tracking-widest title-font mb-1 font-medium">SPECIAL</h2>--}}
{{--                    <h1 class="text-5xl text-gray-900 leading-none flex items-center pb-4 mb-4 border-b border-gray-200">--}}
{{--                        <span>$72</span>--}}
{{--                        <span class="text-lg ml-1 font-normal text-gray-500">/mo</span>--}}
{{--                    </h1>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Vexillologist pitchfork--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Tumeric plaid portland--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Hexagon neutra unicorn--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-2">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Vexillologist pitchfork--}}
{{--                    </p>--}}
{{--                    <p class="flex items-center text-gray-600 mb-6">--}}
{{--            <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">--}}
{{--              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">--}}
{{--                <path d="M20 6L9 17l-5-5"></path>--}}
{{--              </svg>--}}
{{--            </span>Mixtape chillwave tumeric--}}
{{--                    </p>--}}
{{--                    <button class="flex items-center mt-auto text-white bg-gray-400 border-0 py-2 px-4 w-full focus:outline-none hover:bg-gray-500 rounded">Button--}}
{{--                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">--}}
{{--                            <path d="M5 12h14M12 5l7 7-7 7"></path>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                    <p class="text-xs text-gray-500 mt-3">Literally you probably haven't heard of them jean shorts.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
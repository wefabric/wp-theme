@php
    $pageTitle = $page['title'] ?? '';
    $pageUrl = $page['url'] ?? '';
    $pageIcon = json_decode($page['icon'], true);
    $imageID = $page['image_id'] ?? 0;

    // Retrieve the excerpt of the page
    $pageExcerpt = get_the_excerpt($page['id']);
@endphp

@if ($cardVariant == 'variant1')
    <div class="card-item group h-full">
        <div class="relative bg-{{ $cardBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-center text-center text-{{ $cardTextColor }} rounded-{{ $borderRadius }} group-hover:-translate-y-4 duration-300 ease-in-out"
             style="background-image: url('{{ wp_get_attachment_image_url($imageID, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
            <a href="{{ $pageUrl }}"
               class="absolute h-full w-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>
            @if ($pageIcon)
                <a href="{{ $pageUrl }}">
                    <i class="relative z-20 text-[60px] md:text-[100px] fas fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-white transition-all duration-300 ease-in-out"></i>
                </a>
            @endif
            <a href="{{ $pageUrl }}"
               class="relative z-20 h4 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
                {{ $pageTitle }}
            </a>
        </div>
    </div>

@elseif ($cardVariant == 'variant2')
    <div class="card-item group h-full">
        <div class="bg-{{ $cardBackgroundColor }} text-{{ $cardTextColor }} rounded-{{ $borderRadius }} h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out overflow-hidden">
            <div>
                <div class="h-[360px] relative overflow-hidden rounded-{{ $borderRadius }}">
                    @if ($pageIcon)
                        <div class="h-full flex justify-center items-center">
                            <i class="relative z-20 text-[200px] fas fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-primary transition-all duration-300 ease-in-out"></i>
                        </div>
                    @endif
                    @if($imageID)
                        <a href="{{ $pageUrl }}"
                           class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>

                        @include('components.image', [
                           'image_id' => $imageID,
                           'size' => 'full',
                           'object_fit' => 'cover',
                           'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                           'alt' => 'no alt'
                        ])
                    @endif
                </div>
            </div>
            <div class="h-full flex flex-col gap-y-4 p-8">
                <a href="{{ $pageUrl }}"
                   class="relative z-20 h3 font-bold group-hover:text-primary transition-all duration-300 ease-in-out">
                    {{ $pageTitle }}
                </a>

                @if ($pageExcerpt)
                    <p>{{ $pageExcerpt }}</p>
                @endif

                <div class="mt-4 flex items-center flex-wrap">
                    <a href="{{ $pageUrl }}" class="text-primary inline-flex items-center md:mb-2 lg:mb-0">Lees meer
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 group-hover:scale-110 transition duration-300 ease-in-out"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endif
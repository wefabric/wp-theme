@php
    $pageTitle = $page['title'] ?? '';
    $pageUrl = $page['url'] ?? '';
    $pageIcon = json_decode($page['icon'], true);
    $imageId = $page['image_id'] ?? 0;
@endphp

<div class="card-item group h-full text-center block">
    <div class="cardbackground bg-background-color-dark aspect-square w-full flex flex-col gap-y-4 items-center justify-center text-primary rounded-{{ $borderRadius }} group-hover:-translate-y-4 duration-300 ease-in-out"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
        <a href="{{ $pageUrl }}"
           class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
        @if ($pageIcon)
            <a href="{{ $pageUrl }}">
                <i class="relative z-20 group-hover:text-white text-[60px] md:text-[100px] fas fa-{{ $pageIcon['id'] }}"></i>
            </a>
        @endif
        <a href="{{ $pageUrl }}" class="relative z-20 h4 font-bold group-hover:text-white">
            {{ $pageTitle }}
        </a>
    </div>
</div>
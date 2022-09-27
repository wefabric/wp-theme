@php
    if(! isset($postId)) {
        $postId = $item; //in case of slider, or news page
    }
    $fields = get_fields($postId);
    $service = get_post($postId);

    $categories = get_the_category($postId);
@endphp

<div class="hover:shadow-3xl max-w-md flex flex-col mx-auto h-full relative px-2 {{ (isset($lg_hidden) && $lg_hidden) ? 'hidden lg:block' : '' }}">
    <div class="mx-auto mb-5 w-full rounded-lg">
        @include('components.image', [
            'image_id' => $fields['image'],
			'size' => 'news-thumbnail',
            'img_class' => 'rounded-t-lg',
        ])
    </div>

    <div class="px-5">
        <div class="text-base text-gray-400 font-bold leading-relaxed">
            {{ $categories[0]->name }}
        </div>

        <div class="">
            @include('components.headings.normal', [
                'type' => 'h4',
                'heading' => get_the_title($postId),
                'class' => ''
            ])
        </div>

        <div class="pb-16">
            @include('components.content', [
                'content' => get_the_excerpt($postId),
            ])
        </div>

        <div class="absolute bottom-0 right-5 w-full pb-5">
            <div class="text-right text-base text-bold">
                @include('components.link.opening', [
                    'href' => get_permalink($postId),
                    'alt' => 'Lees meer',
                    'class' => 'no-underline',
                ])
					<span class="">Lees meer</span>
					<i class="fa-solid fa-circle-caret-right ml-2"></i>
                @include('components.link.closing')
            </div>
        </div>
    </div>
</div>
@php
    if(! isset($postId)) {
        $postId = $item; //in case of slider
    }
    $fields = get_fields($postId);
    $service = get_post($postId);

    $categories = get_the_category($postId);
@endphp

<div class="hover:shadow-3xl max-w-md flex flex-col mx-auto h-full relative">
    <div class="mx-auto mb-5 w-full h-52 rounded-lg">
        @include('components.image', [
            'image_id' => $fields['image'],
			'size' => 'news-thumbnail',
            'img_class' => 'rounded-t-lg',
        ])
    </div>

    <div class="px-5">
        <div class="text-sm text-gray">
            {{ $categories[0]->name }}
        </div>

        <div class="">
            @include('components.headings.normal', [
                'type' => '3',
                'heading' => get_the_title($postId),
                'class' => 'text-center'
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
                ])
                <span>
                    Lees meer
                    <i class="fa-solid fa-circle-caret-right "></i>
                </span>
                @include('components.link.closing')
            </div>
        </div>
    </div>
</div>
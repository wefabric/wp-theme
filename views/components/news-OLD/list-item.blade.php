@php
    $fields = get_fields($post);

// echo "<pre>"; print_r(get_the_category($post)->name); echo "</pre>"; die();

@endphp

<div class="slider-item">
    <div>
        Image

        @if(get_the_title($post))
            <h3>{!! get_the_title($post) !!}</h3>
        @endif

        @foreach(get_the_category($post) as $category)
            <span class="block">{{ $category->name }}</span>
        @endforeach

        <span class="block">{{ get_the_date('d M y', $post) }}</span>

        <a href="{{ get_permalink($post) }}" class="btn btn-primary">
            {{ __('Lees meer', 'wefabric') }}
        </a>
    </div>
</div>
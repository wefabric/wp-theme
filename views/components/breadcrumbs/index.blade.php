<div class="flex mx-auto mt-12 {{ $classes ?? 'w-4/5 lg:w-3/5' }} {{ $text_color ?? 'text-purple' }} ">
    <a class="self-center mr-1" href=" {{ get_home_url()  }} ">
        <div class="self-center {{ $icon ?? 'breadcrumb-home' }}"></div>
    </a>
    <div>
        {!! yoast_breadcrumb() !!}
    </div>

</div>
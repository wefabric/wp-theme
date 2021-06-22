<a class="btn {{ $classes ?? 'btn-primary' }}" href="{{ $button->get('link_external') ? $button->get('link_external')['url'] : $button->get('link')['url'] }}">
    {{ $button->get('title') }}
</a>
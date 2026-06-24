<a href="{{ $href }}"

    title="{{ $alt }}"
    aria-label="{{ $alt }}"

    @if(!empty($class))
       class="{{ $class }}"
    @endif

    @if(!empty($target) && $target === '_blank')
        rel="{{ !empty($rel) ? $rel : 'noopener noreferrer' }}"
    @elseif(!empty($rel))
        rel="{{ $rel }}"
    @endif

    @if(!empty($target))
       target="{{ $target }}"
    @endif

   @if(!empty($download))
       download
   @endif

	@if(!empty($attributes))
		@foreach($attributes as $key => $value)
			{{ $key }}="{{ $value }}"
		@endforeach
	@endif
>
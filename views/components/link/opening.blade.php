<a href="{{ $href }}"

    aria-label="{{ $alt }}"

    @if(!empty($class))
       class="{{ $class }}"
    @endif

    @if(!empty($rel) || (!empty($target) && $target === '_blank'))
        rel="{{ !empty($rel) ? $rel : 'noopener noreferrer' }}"
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
@php
	$categoryFields = get_fields($category);
@endphp
<span class="flex rounded-md text-white px-4 py-2 mt-4 md:mt-0 uppercase h-[37px]
	@if($active ?? false) border-2 shadow-sm @endif
	@if(isset($categoryFields['color']))bg-{{ str_replace('-color', '', $categoryFields['color'])}}
		@if($active ?? false) border-{{ str_replace(['-light', '-color'], '', $categoryFields['color'])}}-dark @endif
	@else bg-primary-light @endif">
 
	@if(isset($categoryFields['icon']) && $categoryFields['icon'])
		{!! wp_get_attachment_image($categoryFields['icon'], 'thumbnail', false, ['class' => 'w-full h-5 md:h-auto mr-2']) !!}
	@endif
    <span class="self-center leading-none font-bold">{{ $category->name }}</span>
</span>

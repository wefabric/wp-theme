@php
$content = '';

if(isset($outOfOffice['content']) && $outOfOffice['content']) {
    $content = preg_replace('/<p([^>]+)?>/', '<p class="text-base leading-6">', $outOfOffice['content'], 1);
}
@endphp

<div class="fixed px-2 lg:px-0 lg:right-2 top-1/4 transform translate-y-1/4  lg:top-1/2 lg:transform translate-y-1/2 w-full lg:w-96 shadow-xl rounded-md hidden z-[100]" id="popup">
    <div class="bg-primary p-3 rounded-t-md">
        <h2 class="text-md text-white">{!! $outOfOffice['title'] !!}</h2>
    </div>
    <div class="bg-white text-base p-3 rounded-b-md">
        {!! apply_filters('the_content', $content) !!}
        <a class="btn btn-small btn-primary text-sm mt-5" id="popup-close">{!! $outOfOffice['btn_text'] === '' ? 'Sluiten' : $outOfOffice['btn_text']  !!}</a>
    </div>
</div>
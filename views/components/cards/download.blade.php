
<div class="card bg-white flex flex-col justify-center h-full">
    <div class="bg-[#F9F9F9] rounded-tl-lg rounded-tr-lg flex flex-col justify-center p-8">
        @include('components.image', [
           'image_id' => $item->get('image'),
           'size' => 'brand_logo',
           'class' => ' mx-auto h-[200px] flex items-center',
           'img_class' => 'bg-center bg-no-repeat relative ',
       ])
    </div>

    <div class="h5 py-5 text-center">
        {{ $item->get('title') }}
    </div>

    <div class="pb-8 flex flex-col">
        @include('components.buttons.default', [
          'href' => $item->get('file')->get('url'),
          'text' => $item->get('download_button_text'),
          'colors' => 'bg-gray-100 text-black',
          'class' => 'hover:bg-primary hover:text-white',
          'a_class' => 'self-center ',
          'alt' => $item->get('download_button_text'),
          'target' => '_blank',
          'icon' => 'fa-solid text-sm align-top pt-0.5 pl-1 ' . \App\Helpers\Fontawesome::getFileTypeIconClass($item->get('file')->get('mime_type')),
      ])
    </div>

</div>
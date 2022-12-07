@if($technicalSheet = get_field('technical_sheet', $product->get_id()))
    <a class="inline-block mb-4" href="{{ wp_get_attachment_url($technicalSheet) }}">
        <span class="inline-block rounded-full px-4 py-2 text-primary border-primary border mb-4 hover:bg-primary hover:text-white transition-all" target="_blank"> Technisch gegevensblad <i class="fa-regular fa-file-pdf pl-2"></i></span>
    </a>
@endif
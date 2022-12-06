@if($extraFiles = \App\Helpers\Product::getExtraFilesAsCollection(get_the_ID()))
    @if($extraFiles->count())
        <section class="extra-files my-16">
            <h2 class="pb-6">Downloads</h2>
            @include('components.slider.grid', [
                'items' => $extraFiles,
                'card_type' => 'download',
            ])
        </section>
    @endif
@endif
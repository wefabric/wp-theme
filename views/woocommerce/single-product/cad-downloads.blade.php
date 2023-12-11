@if($cadDownloads = \App\Helpers\Product::getCadDownloadsCollection(get_the_ID()))
    @if($cadDownloads->count())
        <section class="extra-files cad-downloads my-16 w-full">
            <h2 class="pb-6">CAD Downloads</h2>
            <div class="w-full">
                <div class="cad-downloads-table grid grid-cols-1 lg:grid-cols-{{ $cadDownloads->count() }} ">
                    @foreach($cadDownloads as $cadType => $downloads)
                        <div>
                            <div class="bg-black text-white p-4 px-8 rounded-lg
                                        @if($loop->first)  lg:rounded-tl-lg lg:rounded-tr-none lg:rounded-bl-lg lg:rounded-br-none
                                        @elseif($loop->last) lg:rounded-tr-lg lg:rounded-tl-none  lg:rounded-br-lg lg:rounded-bl-none
                                        @else rounded-none
                                        @endif">
                                {{ $cadType }}
                            </div>
                            <div class="px-4 pt-4">
                                <div class="grid grid-cols-2 gap-x-4 lg:grid-cols-1 lg:gap-0">
                                    @foreach($downloads->take(4) as $download)
                                        <a class="mb-4 bg-white text-primary rounded-full w-full px-4 py-2 border border-primary inline-block hover:bg-primary hover:text-white transition-all flex items-center justify-between" target="_blank" href="{{ $download->get('url') }}" rel="nofollow">
                                            {{ $download->get('title') }}
                                            <i class="fa-regular fa-download"></i>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="hidden downloads-list grid grid-cols-2 gap-x-4 lg:grid-cols-1 lg:gap-0">
                                    @foreach($downloads->slice(4) as $download)
                                        <a class="mb-4 bg-white text-primary rounded-full w-full px-4 py-2 border border-primary inline-block hover:bg-primary hover:text-white transition-all flex items-center justify-between" target="_blank" href="{{ $download->get('url') }}" rel="nofollow">
                                            {{ $download->get('title') }}
                                            <i class="pl-2 fa-regular fa-download"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($downloads->count() > 5)
                    <div class="text-center mt-4">
                        <button class="button cad-downloads-toggle">Toon alles</button>
                    </div>
                @endif
            </div>
        </section>
    @endif
@endif
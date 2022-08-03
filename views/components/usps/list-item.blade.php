<div class="@if($usp->get('title')) mb-14 @else mb-6 @endif @if($usp->get('url')) group hover:text-secondary cursor-pointer @endif">
    @if($usp->get('external_url'))
        <a href="{{ $usp->get('external_url') }}" aria-label="{{ $usp->get('title')}}">
    @elseif($usp->get('page_url'))
        <a href="{{ $usp->get('page_url') }}" aria-label="{{ $usp->get('title')}}">
    @endif
        <div class="flex flex-row">
            <div>
                @if($icon = $usp->get('icon'))
                    <i class="{{ $icon }} bg-black text-white p-2 mr-6 @if($usp->get('url')) group-hover:bg-secondary @endif"></i>
                @endif
            </div>
            <div>
                @if($usp->get('title'))
                    <h3 class="block mb-3 break-all">{{ $usp->get('title') }}</h3>
                @else
                    <span class="group-hover:font-bold inline-block mt-1 ">{{ $usp->get('text') }}</span>
                @endif
            </div>
        </div>
        @if($usp->get('title'))
            <div class="">
                <div class="@if($usp->get('url')) group-hover:text-primary @endif">
                    {{ $usp->get('text') }}
                </div>
            </div>
        @endif

    @if($usp->get('page_url') || $usp->get('external_url'))
        </a>
    @endif
</div>
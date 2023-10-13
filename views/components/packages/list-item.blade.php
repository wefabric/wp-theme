@php
    $packageTitle = $package['title'] ?? '';
    $packagePrice = $package['price'] ?? '';
    $packageDescription = $package['description'] ?? '';
    $packageLabel = $package['label'] ?? '';
    $packagePricePer = $package['price_per'] ?? '';

    $packageBackgroundColor = $package['package_background_color'] ?? '';
    $packageTextColor = $package['text_color'] ?? '';
//@dd($packageTextColor)
@endphp

<div class="w-full h-full flex flex-col relative bg-background-color rounded-{{ $borderRadius }}">
    <div class="p-6 bg-{{ $packageBackgroundColor }} text-{{ $packageTextColor }} rounded-t-{{ $borderRadius }}">
        @if ($packageLabel)
            <span class="bg-primary font-medium text-white px-4 py-2 absolute left-1/2 -translate-x-1/2 top-0 -translate-y-1/2 rounded-full">{{ $packageLabel }}</span>
        @endif
        <h3 class="text-xl font-bold">{{ $packageTitle }}</h3>
        <div class="text-3xl font-bold flex items-center mb-2">€ {{ $packagePrice }}
            @if ($packagePricePer)
                <span class="text-lg ml-1 font-normal">/ {{ $packagePricePer }}</span>
            @endif
        </div>
        @if ($packageDescription)
            <p>{{ $packageDescription }}</p>
        @endif
    </div>
    <div class="flex flex-col h-full justify-between p-6 mt-4 gap-y-8">
        <div class="bulletpoints">
            @if ($package['bulletpoints'] && is_array($package['bulletpoints']))
                @foreach ($package['bulletpoints'] as $bulletpoint)
                    <p class="flex items-center text-gray-600 mb-2">
                        <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                 class="w-3 h-3" viewBox="0 0 24 24">
                                <path d="M20 6L9 17l-5-5"></path>
                            </svg>
                        </span>
                        <span class="font-bold">{{ $bulletpoint['title'] }}</span>
                    </p>
                    <p class="text-gray-500 ml-6 mb-4">
                        {{ $bulletpoint['text'] }}
                    </p>
                @endforeach
            @endif
        </div>
        <div class="">
            <a href="#" class="mt-auto group bg-secondary hover:bg-secondary-dark flex items-center text-primary border-0 py-2 px-4 w-full md:w-2/3 mx-auto focus:outline-none">
                Aanmelden
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                     stroke-width="2" class="w-4 h-4 ml-auto group-hover:translate-x-2 ease-in-out duration-300 transition-all" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
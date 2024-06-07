@php
    $processImage = $processStep['image'];
    $processTitle = $processStep['step_title'];
    $processText = $processStep['step_text'];
    $processIcon = $processStep['icon'];
    $processUrl = $processStep['step_url'];
@endphp

<div class="process-card group relative z-10">
    <div class="bg-white rounded-{{ $borderRadius }} h-full flex flex-col duration-300 ease-in-out overflow-hidden">

        <div class="image-container h-[200px] relative overflow-hidden rounded-t-{{ $borderRadius }}">
            @if ($processImage)
                @if ($processUrl)
                    <a href="{{ $processUrl }}" aria-label="Ga naar {{ $processUrl }} pagina" class="image-overlay absolute left-0 w-full h-full bg-white z-10 opacity-80 group-hover:opacity-0 transition-opacity duration-300 ease-in-out"></a>
                @else
                    <div class="absolute left-0 w-full h-full bg-white z-10 opacity-50 group-hover:opacity-0 transition-opacity duration-300 ease-in-out"></div>
                @endif
                @include('components.image', [
                    'image_id' => $processImage,
                    'size' => 'job-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                    'alt' => $processStep
                ])
            @endif

            <div class="step-icon text-secondary absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 text-[60px] opacity-100 group-hover:opacity-0 transition-opacity duration-300 ease-in-out">{!! $processIcon !!}</div>
        </div>

        <div class="content-box h-full flex flex-col p-6 xl:p-8">

            @if ($processUrl)
                <a href="{{ $processUrl }}" aria-label="Ga naar {{ $processTitle }} pagina"
                   class="card-title text-primary relative z-20 h3 group-hover:text-primary-dark transition-all duration-300 ease-in-out">
                    {!! $processTitle !!}
                </a>
            @else
                <div class="card-title text-primary relative z-20 h3 transition-all duration-300 ease-in-out">
                    {!! $processTitle !!}
                </div>
            @endif

            <div class="expandable-content overflow-hidden max-h-0 group-hover:max-h-[300px] transition-all duration-300 ease-in-out">

                @if ($processText)
                    <div class="mt-4 card-excerpt text-{{ $cardTextColor }}">{!! $processText !!}</div>
                @endif

                @if ($processUrl)
                    <div class="mt-4 z-10">
                        @include('components.buttons.default', [
                            'text' => 'Read more',
                            'href' => $processUrl,
                            'alt' => 'Read more',
                            'colors' => 'btn-cta btn-underline',
                        ])
                    </div>
               @endif
            </div>
        </div>
    </div>
</div>

<div class="process-number font-light absolute top-[-85px] right-[-32px] -z-10 text-[90px]">0{{ $index + 1 }}</div>
<div class="breadcrumbs breadcrumbs-{{ $breadcrumbsLocation }} {{ $headerName }} w-full py-4 lg:py-8 bg-{{ $breadcrumbsBackgroundColor ?? 'bg-transparent' }} text-{{ $breadcrumbsTextColor ?? 'text-black' }}">
    <div class="relative z-10 @if ($breadcrumbsLocation === 'underneath' || $breadcrumbsLocation === 'above') px-8 container mx-auto @endif">
        <div>
            @php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); @endphp
            @php if (function_exists('yoast_breadcrumb')) echo yoast_breadcrumb(); @endphp
        </div>
    </div>
</div>
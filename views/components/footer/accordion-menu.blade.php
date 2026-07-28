<div class="accordion-item mb-3">
    <div class="leading-relaxed">
        @php $useAccordion = $setAccordion === true && !empty($title); @endphp
        <div class="@if($useAccordion) accordion-drawer @endif">
            @if($useAccordion)
                <input class="accordion-drawer__trigger mb-4" id="accordion-drawer-{{ $accordionId }}" type="checkbox" />
                <label class="accordion-drawer__title relative block h5 py-4 text-{{ $title_color ?? '' }}" for="accordion-drawer-{{ $accordionId }}">
                    {!! $title !!}
                </label>
            @elseif(!empty($title))
                <div class="accordion-drawer__title relative block h5 py-4 text-{{ $title_color ?? '' }}">
                    {!! $title !!}
                </div>
            @endif
            <div class="@if($useAccordion) accordion-drawer__content-wrapper @endif">
                <div class="@if($useAccordion) accordion-drawer__content @endif">
                    <p class="text-base text-primary">
                        {!! $menu !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

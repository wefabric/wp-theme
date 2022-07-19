<div class="mb-3">
    <div class="text-sm leading-9">
        <div class="@if($setAccordion === true) accordion-drawer @endif">
            @if($setAccordion === true) <input class="accordion-drawer__trigger mb-4" id="accordion-drawer-{{ $accordionId }}" type="checkbox" /> @endif
            <label class="accordion-drawer__title relative block text-lg font-bold py-4" for="accordion-drawer-{{ $accordionId }}">
                {!! $title !!}
            </label>
            <div class="@if($setAccordion === true) accordion-drawer__content-wrapper @endif">
                <div class="@if($setAccordion === true) accordion-drawer__content @endif">
                    <p class="text-base text-primary">
                        {!! $menu !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
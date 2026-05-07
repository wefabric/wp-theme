<div class="footer-custom-section">
    @if(!empty($customText))
        <div class="footer-custom-text text-base leading-7">
            {!! $customText !!}
        </div>
    @endif

    @if(!empty($customButtonLink['url']))
        <div class="footer-custom-button mt-4">
            @include('components.buttons.default', [
                'text'     => $customButtonLink['title'] ?? '',
                'href'     => $customButtonLink['url'],
                'alt'      => $customButtonLink['title'] ?? '',
                'target'   => $customButtonLink['target'] ?? '_self',
                'colors'   => 'btn-' . ($customButtonColor ?? 'primary-color') . ' btn-' . ($customButtonStyle ?? 'filled'),
                'class'    => 'rounded-lg',
                'icon'     => $customButtonIcon ?? '',
                'download' => $customButtonDownload ?? false,
            ])
        </div>
    @endif
</div>

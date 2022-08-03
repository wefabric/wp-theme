<div class="justify-end hidden pt-2 px-4 lg:flex bg-{{ $bg_color }}">
    @if(isset($options['contact_phone']) && $phone = $options['contact_phone'])
        <a href="tel:{{ str_replace([' ', '-'], '', $phone) }}" target="_blank" class="mr-3">
            <i class="fas fa-phone mr-3"></i><span class="d-none d-lg-inline-block"></span>
        </a>
    @endif
    @if (isset($options['contact_email']) && $email = $options['contact_email'])
        <a href="mailto:{{ $email }}" class="default-color-link mr-3" target="_blank"><i class="fas fa-envelope contact-icon-header mr-3"></i></a>
    @endif
    @if (isset($options['contact_appointment']) && $button = $options['contact_appointment'])
        <a class="btn btn-small bg-primary text-white" href="{{ $button['link'] }}">
            {{ $button['title'] }}
        </a>
    @endif
    @if (has_nav_menu('primary_navigation'))
        <nav class="nav-primary">
            {!! wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'menu_class'     => 'nav'
            ]) !!}
        </nav>
    @endif
</div>

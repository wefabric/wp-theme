@php
  $setAccordion = true;
@endphp

<div class="block md:hidden container mx-auto">
    <div class="px-5">

        {{-- Footer menu one --}}
        @if(isset($options['footer_block_one_title']) and $options['footer_block_one_title'])
            <div class="mb-3">
                <div class="text-sm leading-9">
                    <div class="@if($setAccordion === true) accordion-drawer @endif">
                        @if($setAccordion === true) <input class="accordion-drawer__trigger mb-4" id="accordion-drawer-1" type="checkbox" /> @endif
                        <label class="accordion-drawer__title relative block @if($setAccordion === true) cursor-pointer @endif border-b border-white text-md pt-4 pb-2 pr-6 text-primary" for="accordion-drawer-1">
                            {{ $options['footer_block_one_title'] }}
                        </label>
                        <div class="@if($setAccordion === true) accordion-drawer__content-wrapper @endif">
                            <div class="@if($setAccordion === true) accordion-drawer__content @endif">
                                <p class="text-base text-primary pt-2">
                                    {!! wp_nav_menu([
                                      'theme_location' => 'footer-menu-one',
                                      'menu_id' => 'footer-menu-one',
                                      'echo' => false
                                    ]) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End footer menu one--}}

        {{-- Footer menu two --}}
        @if(isset($options['footer_block_two_title']) and $options['footer_block_two_title'])
            <div class="mb-3">
                <div class="text-sm leading-9">
                    <div class="@if($setAccordion === true) accordion-drawer @endif">
                        @if($setAccordion === true) <input class="accordion-drawer__trigger mb-4" id="accordion-drawer-2" type="checkbox" /> @endif
                        <label class="accordion-drawer__title relative block @if($setAccordion === true) cursor-pointer @endif border-b border-white text-md pt-4 pb-2 pr-6 text-primary" for="accordion-drawer-2">
                            {{ $options['footer_block_two_title'] }}
                        </label>
                            <div class="@if($setAccordion === true) accordion-drawer__content-wrapper @endif">
                                <div class="@if($setAccordion === true) accordion-drawer__content @endif">
                                <p class="text-base text-primary pt-2">
                                    {!! wp_nav_menu([
                                        'theme_location' => 'footer-menu-two',
                                        'menu_id' => 'footer-menu-two',
                                        'echo' => false
                                    ]) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End footer menu two --}}

        {{-- Footer menu three --}}
        @if($options['footer_block_three_title'] and $options['footer_block_three_title'])
            <div class="mb-3">
                <div class="text-sm leading-9">
                    <div class="@if($setAccordion === true) accordion-drawer @endif">
                        @if($setAccordion === true) <input class="accordion-drawer__trigger mb-4" id="accordion-drawer-3" type="checkbox" /> @endif
                        <label class="accordion-drawer__title relative block @if($setAccordion === true) cursor-pointer @endif border-b border-white text-md pt-4 pb-2 pr-6 text-primary" for="accordion-drawer-3">
                            {{ $options['footer_block_three_title'] }}
                        </label>
                            <div class="@if($setAccordion === true) accordion-drawer__content-wrapper @endif">
                                <div class="@if($setAccordion === true) accordion-drawer__content @endif">
                                <div class="text-base text-primary pt-2 contact-information">
                                    @if(isset($options['contact_information']) and $options['contact_information'])
                                        {!! $options['contact_information'] !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End footer menu three --}}

        {{-- Footer menu four --}}
        @if(isset($options['footer_block_four_title']) and $options['footer_block_four_title'])
            <div class="mb-3">
                <div class="text-sm leading-9">
                    <div class="@if($setAccordion === true) accordion-drawer @endif">
                        @if($setAccordion === true) <input class="accordion-drawer__trigger mb-4" id="accordion-drawer-4" type="checkbox" /> @endif
                        <label class="accordion-drawer__title relative block @if($setAccordion === true) cursor-pointer @endif border-b border-white text-md pt-4 pb-2 pr-6 text-primary" for="accordion-drawer-4">
                            {{ $options['footer_block_four_title'] }}
                        </label>
                        <div class="accordion-drawer__content-wrapper">
                            <div class="accordion-drawer__content">
                                @if(isset($options['contact_information']) and $options['contact_information'])
                                    <p class="text-base text-primary pt-2 pb-4">
                                        {!! $options['footer_news_text_field'] !!}
                                    </p>
                                @endif
                                <div class="pt-4">
                                    @if(isset($options['channels']) and $options['channels']))
                                        @foreach($options['channels'] as $social)
                                            <a href="{{ $social['url'] }}">
                                                <i class="{{ $social['icon'] }} w-9 h-9 py-1 text-lg bg-cta text-white text-white text-center hover:bg-secondary hover:text-underline mr-4"></i>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End footer menu four --}}
    </div>

    {{-- Start footer bottom --}}
    <div class="px-4 grid grid-cols-2 pt-8">
        <div class=" text-primary pb-6 text-center">
            @if($logoId = get_field('common', 'option')['logo'])
                {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => '']) !!}
            @endif
        </div>
        <div class="col-span-2 mobile-ul-menu-footer text-primary text-sm pt-8">
            {!! wp_nav_menu([
                'theme_location' => 'footer-menu-three',
                'menu_id' => 'footer-menu-three',
                'echo' => false
            ]) !!}
        </div>
    </div>
    <div class="pb-10 px-4">
        <div class="text-sm mt-10 grid grid-cols-2">
            <div>
                <span class="sep text-primary pr-4 made-by">Gerealiseerd door</span>
            </div>
            <div>
                <img src="" class="h-4 pt-1" alt="wefabric"/>
            </div>
        </div>
    </div>
    {{-- End footer bottom --}}

</div>
{{-- Start desktop --}}
<div class="hidden md:block container mx-auto">

    <div class="grid md:grid-cols-2 lg:grid-cols-4 lg:py-16 text-primary px-5 pt-20 lg:pt-32">

        <div class="md:pr-16 mb-6">
            @if(isset($options['footer_block_one_title']) and $options['footer_block_one_title'])
                <h3>{{ $options['footer_block_one_title'] }}</h3>
            @endif
            <div class="text-base leading-9 pt-4">
                {!! wp_nav_menu([
                  'theme_location' => 'footer-menu-one',
                  'menu_id' => 'footer-menu-one',
                  'echo' => false
                ]) !!}
            </div>
        </div>

        <div class="md:pr-16 mb-6">
            @if(isset($options['footer_block_two_title']) and $options['footer_block_two_title'])
                <h3>{{ $options['footer_block_two_title'] }}</h3>
            @endif
            <div class="text-base leading-9 pt-4">
                {!! wp_nav_menu([
                      'theme_location' => 'footer-menu-two',
                      'menu_id' => 'footer-menu-two',
                      'echo' => false
               ]) !!}
            </div>
        </div>

        <div class="mb-6 col-span-2 md:col-span-1">
            @if(isset($options['footer_block_three_title']) and $options['footer_block_three_title'])
                <h3>{{ $options['footer_block_three_title'] }}</h3>
            @endif

            @if(isset($options['contact_information']) and $options['contact_information'])
                <div class="text-base leading-9 pt-4">
                    {!! $options['contact_information'] !!}
                </div>
            @endif
        </div>

        <div class="mb-6 col-span-2 md:col-span-1">
            @if(isset($options['footer_block_four_title']) and $options['footer_block_four_title'])
                <h3>{{ $options['footer_block_four_title'] }}</h3>
            @endif

            @if(isset($options['contact_information']) and $options['contact_information'])
                <div class="text-base leading-9 pt-4">
                    {!! $options['contact_information'] !!}
                </div>
            @endif
        </div>
    </div>

    {{-- Start footer bottom --}}
    <div class="px-4 grid lg:grid-cols-6 lg:px-4 xl:px-0">
        <div class="col-span-2">
            @if($logoId = get_field('common', 'option')['logo'])
                {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => '']) !!}
            @endif
        </div>
        <div class="col-span-4">
            <div class="container">
                <div class="grid lg:grid-cols-5 lg:pt-8 text-primary">
                    <div class="footer-bottom flex lg:col-span-2 text-sm text-primary">
                        {!! wp_nav_menu([
                         'theme_location' => 'footer-menu-three',
                         'menu_id' => 'footer-menu-three',
                         'echo' => false
                       ]) !!}
                    </div>
                    <div></div>
                    <div class="text-sm mt-10 flex col-span-2 justify-end">
                        <span class="sep text-primary pr-4">Gerealiseerd door</span>
                        <img src="" class="h-4 pt-1" alt="logo" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End footer bottom --}}
</div>
{{--End desktop--}}

{{-- Include mobile menu --}}
@include('components.footer.mobile-footer')
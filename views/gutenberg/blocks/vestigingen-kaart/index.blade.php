@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $subtitleIcon = $block['data']['subtitle_icon'] ?? '';
    $subtitleIcon = $subtitleIcon ? json_decode($subtitleIcon, true) : null;
    $subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';
    $button1Download = $block['data']['button_button_1_download'] ?? false;
    $button1Icon = $block['data']['button_button_1_icon'] ?? '';
    if (!empty($button1Icon)) {
        $iconData = json_decode($button1Icon, true);
        if (isset($iconData['id'], $iconData['style'])) {
            $button1Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
        }
    }
    $button2Text = $block['data']['button_button_2']['title'] ?? '';
    $button2Link = $block['data']['button_button_2']['url'] ?? '';
    $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
    $button2Color = $block['data']['button_button_2_color'] ?? '';
    $button2Style = $block['data']['button_button_2_style'] ?? '';
    $button2Download = $block['data']['button_button_2_download'] ?? false;
    $button2Icon = $block['data']['button_button_2_icon'] ?? '';
    if (!empty($button2Icon)) {
        $iconData = json_decode($button2Icon, true);
        if (isset($iconData['id'], $iconData['style'])) {
            $button2Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
        }
    }

    $textPosition = $block['data']['text_position'] ?? '';
    $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end'];
    $textClass = $textClassMap[$textPosition] ?? '';

    // Kaart
    $mapImageId = $block['data']['map_image'] ?? '';
    $legend = \Theme\Helpers\AcfRepeater::parse($block['data'], 'legend');
    $pins = \Theme\Helpers\AcfRepeater::parse($block['data'], 'pins');

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    if (!is_array($visibleElements)) {
        $visibleElements = [];
    }
    $defaultPinColor = $block['data']['default_pin_color'] ?: 'primary-color';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';

    $randomNumber = rand(0, 1000);
    $mapId = 'vestigingen-kaart-' . $randomNumber;

    // Vestigingen data per pin opbouwen
    $pinsData = [];

    foreach ($pins as $index => $pin) {
        $establishmentId = $pin['establishment'] ?? null;
        $establishmentName = $pin['label'] ?: '';
        $items = [];

        // Vestigingsgegevens ophalen (indien gekoppeld). Zonder koppeling wordt de pin
        // alsnog getoond (met eventueel het handmatige label), zodat je 'm direct op de
        // kaart kunt positioneren voordat je de vestiging koppelt.
        if ($establishmentId) {
            $establishmentModel = new \Wefabric\WPEstablishments\Establishment($establishmentId);
            if (!$establishmentName) {
                $establishmentName = $establishmentModel->name ?? get_the_title($establishmentId);
            }

            $addressDto = $establishmentModel->getAddress();
            $street = $addressDto->street ?? '';
            $houseNumber = $addressDto->housenumber ?? '';
            $houseNumberAddition = $addressDto->housenumber_addition ?? '';
            $zipCode = $addressDto->postcode ?? '';
            $city = $addressDto->city ?? '';

            $phone = $establishmentModel->getContactPhone();
            $email = $establishmentModel->getEmailAddress();
            $whatsapp = $establishmentModel->whatsapp_number ?? '';
            $kvkNumber = $establishmentModel->coc_number ?? '';
            $vatNumber = $establishmentModel->vat_number ?? '';
            $overviewText = $establishmentModel->post->post_excerpt ?? '';

            if (in_array('name', $visibleElements)) {
                $items[] = ['type' => 'name', 'value' => $establishmentName];
            }

            if (in_array('address', $visibleElements) && ($street || $city)) {
                $items[] = [
                    'type' => 'address',
                    'line1' => trim($street . ' ' . $houseNumber . $houseNumberAddition),
                    'line2' => trim($zipCode . ' ' . $city),
                ];
            }

            if (in_array('overview_text', $visibleElements) && $overviewText) {
                $items[] = ['type' => 'overview_text', 'value' => $overviewText];
            }

            if (in_array('phone', $visibleElements) && $phone) {
                $items[] = [
                    'type' => 'phone',
                    'href' => $phone->uri(),
                    'value' => get_bloginfo('language') === 'nl-NL' ? $phone->national() : $phone->international(),
                ];
            }

            if (in_array('email', $visibleElements) && $email) {
                $items[] = ['type' => 'email', 'value' => $email];
            }

            if (in_array('whatsapp', $visibleElements) && $whatsapp) {
                $items[] = ['type' => 'whatsapp', 'value' => $whatsapp];
            }

            if (in_array('route', $visibleElements) && $addressDto) {
                $items[] = ['type' => 'route', 'href' => $addressDto->getGoogleMapsUrl()];
            }

            if (in_array('kvk_number', $visibleElements) && $kvkNumber) {
                $items[] = ['type' => 'kvk_number', 'value' => $kvkNumber];
            }

            if (in_array('vat_number', $visibleElements) && $vatNumber) {
                $items[] = ['type' => 'vat_number', 'value' => $vatNumber];
            }
        }

        if (!$establishmentName) {
            $establishmentName = 'Vestiging ' . ((int) $index + 1);
        }

        $pinsData[] = [
            'id' => (int) $index,
            'x' => (float) ($pin['x_position'] ?? 50),
            'y' => (float) ($pin['y_position'] ?? 50),
            'color' => $pin['color'] ?: $defaultPinColor,
            'labelColor' => $pin['label_color'] ?? '',
            'name' => $establishmentName,
            'items' => $items,
        ];
    }
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ $mapId }}@endif" class="block-vestigingen-kaart relative {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}">
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} {{ $textClass }}">
                    @if ($subtitleIcon)
                        <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                    @endif
                    {!! $subTitle !!}
                </span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} {{ $textClass }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ' ' . $textClass
                ])
            @endif

            @if ($mapImageId)
                <div class="vestigingen-kaart-map relative w-full" id="{{ $mapId }}">
                    @include('components.image', [
                        'image_id' => $mapImageId,
                        'size' => 'full',
                        'class' => 'block w-full',
                        'img_class' => 'w-full h-auto select-none pointer-events-none rounded-' . $borderRadius,
                        'alt' => $title ?: 'Vestigingenkaart',
                    ])

                    @foreach ($pinsData as $pinData)
                        <button
                            type="button"
                            class="kaart-pin absolute -translate-x-1/2 -translate-y-1/2 bg-{{ $pinData['color'] }}"
                            style="left: {{ $pinData['x'] }}%; top: {{ $pinData['y'] }}%;"
                            data-pin-index="{{ $pinData['id'] }}"
                            aria-label="{{ $pinData['name'] }}"
                        >
                            <span class="kaart-pin-label bg-{{ $pinData['color'] }} @if($pinData['labelColor']) text-{{ $pinData['labelColor'] }} @else default-label-color @endif">{{ $pinData['name'] }}</span>
                        </button>
                    @endforeach

                    <div class="kaart-popup hidden absolute z-20" data-kaart-popup>
                        <button type="button" class="kaart-popup-close" data-kaart-popup-close aria-label="Sluiten">&times;</button>
                        <div class="kaart-popup-content" data-kaart-popup-content></div>
                    </div>
                </div>

                @if (!empty($legend))
                    <div class="kaart-legenda flex flex-wrap gap-x-6 gap-y-2 mt-4">
                        @foreach ($legend as $legendItem)
                            @if (!empty($legendItem['label']))
                                <div class="kaart-legenda-item flex items-center gap-2">
                                    <span class="kaart-legenda-dot inline-block w-3 h-3 rounded-full bg-{{ $legendItem['color'] ?: $defaultPinColor }}"></span>
                                    <span class="kaart-legenda-label text-sm">{{ $legendItem['label'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endif

            @if (($button1Text) && ($button1Link))
                <div class="buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-8 {{ $textClass }}">
                    @include('components.buttons.default', [
                        'text' => $button1Text,
                        'href' => $button1Link,
                        'alt' => $button1Text,
                        'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                        'class' => 'rounded-lg',
                        'target' => $button1Target,
                        'icon' => $button1Icon,
                        'download' => $button1Download,
                    ])
                    @if (($button2Text) && ($button2Link))
                        @include('components.buttons.default', [
                            'text' => $button2Text,
                            'href' => $button2Link,
                            'alt' => $button2Text,
                            'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                            'class' => 'rounded-lg',
                            'target' => $button2Target,
                            'icon' => $button2Icon,
                            'download' => $button2Download,
                        ])
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<script type="application/json" id="{{ $mapId }}-data">{!! wp_json_encode($pinsData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

<style>
    #{{ $mapId }} .kaart-pin {
        width: 20px;
        height: 20px;
        border-radius: 9999px;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.35);
        cursor: pointer;
        padding: 0;
        transition: transform 0.15s ease-in-out;
    }

    #{{ $mapId }} .kaart-pin:hover,
    #{{ $mapId }} .kaart-pin:focus-visible {
        transform: translate(-50%, -50%) scale(1.15);
    }

    #{{ $mapId }} .kaart-pin-label {
        position: absolute;
        left: 50%;
        bottom: calc(100% + 8px);
        transform: translateX(-50%);
        white-space: nowrap;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.02em;
        padding: 3px 10px;
        border-radius: 4px;
        pointer-events: none;
    }

    #{{ $mapId }} .kaart-pin-label.default-label-color {
        color: #fff;
    }

    #{{ $mapId }} .kaart-popup {
        width: 280px;
        max-width: 80vw;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        padding: 20px 16px 16px;
    }

    #{{ $mapId }} .kaart-popup.hidden {
        display: none;
    }

    #{{ $mapId }} .kaart-popup-close {
        position: absolute;
        top: 4px;
        right: 8px;
        font-size: 20px;
        line-height: 1;
        background: none;
        border: none;
        cursor: pointer;
        color: #666;
    }

    #{{ $mapId }} .kaart-popup a {
        text-decoration: none;
    }

    #{{ $mapId }} .kaart-popup a:hover {
        text-decoration: underline;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mapEl = document.getElementById('{{ $mapId }}');
        if (!mapEl) {
            return;
        }

        var dataEl = document.getElementById('{{ $mapId }}-data');
        var pins = dataEl ? JSON.parse(dataEl.textContent) : [];
        var popup = mapEl.querySelector('[data-kaart-popup]');
        var popupContent = mapEl.querySelector('[data-kaart-popup-content]');
        var closeBtn = mapEl.querySelector('[data-kaart-popup-close]');

        function escapeHtml(value) {
            var div = document.createElement('div');
            div.textContent = value == null ? '' : String(value);
            return div.innerHTML;
        }

        function renderItem(item) {
            switch (item.type) {
                case 'name':
                    return '<p class="kaart-popup-name font-bold text-lg mb-2">' + escapeHtml(item.value) + '</p>';
                case 'address':
                    return '<p class="kaart-popup-address mb-2 leading-snug">' + escapeHtml(item.line1) + '<br>' + escapeHtml(item.line2) + '</p>';
                case 'overview_text':
                    return '<p class="kaart-popup-overview mb-2">' + escapeHtml(item.value) + '</p>';
                case 'phone':
                    return '<a class="kaart-popup-phone flex items-center gap-2 mb-1" href="' + escapeHtml(item.href) + '"><i class="fa-solid fa-phone"></i><span>' + escapeHtml(item.value) + '</span></a>';
                case 'email':
                    return '<a class="kaart-popup-email flex items-center gap-2 mb-1" href="mailto:' + escapeHtml(item.value) + '"><i class="fa-solid fa-envelope"></i><span>' + escapeHtml(item.value) + '</span></a>';
                case 'whatsapp':
                    return '<a class="kaart-popup-whatsapp flex items-center gap-2 mb-1" href="https://wa.me/' + escapeHtml(String(item.value).replace(/\D+/g, '')) + '" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i><span>' + escapeHtml(item.value) + '</span></a>';
                case 'route':
                    return '<a class="kaart-popup-route flex items-center gap-2 mb-1" href="' + escapeHtml(item.href) + '" target="_blank" rel="noopener"><i class="fa-solid fa-route"></i><span>Route</span></a>';
                case 'kvk_number':
                    return '<p class="kaart-popup-kvk mb-1">KvK: ' + escapeHtml(item.value) + '</p>';
                case 'vat_number':
                    return '<p class="kaart-popup-vat mb-1">BTW nummer: ' + escapeHtml(item.value) + '</p>';
                default:
                    return '';
            }
        }

        function openPopup(pin) {
            if (!popup || !popupContent) {
                return;
            }

            popupContent.innerHTML = pin.items.map(renderItem).join('');
            popup.classList.remove('hidden');

            var left = pin.x;
            var top = pin.y;
            var horizontal = left > 60 ? 'translate(-100%, -110%)' : (left < 15 ? 'translate(0, -110%)' : 'translate(-50%, -110%)');

            popup.style.left = left + '%';
            popup.style.top = top + '%';
            popup.style.transform = horizontal;
        }

        mapEl.querySelectorAll('.kaart-pin').forEach(function (pinEl) {
            pinEl.addEventListener('click', function (event) {
                event.stopPropagation();
                var index = parseInt(pinEl.getAttribute('data-pin-index'), 10);
                var pin = pins.find(function (p) { return p.id === index; });
                if (pin) {
                    openPopup(pin);
                }
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                popup.classList.add('hidden');
            });
        }

        document.addEventListener('click', function (event) {
            if (!popup) {
                return;
            }
            if (mapEl.contains(event.target)) {
                return;
            }
            popup.classList.add('hidden');
        });
    });
</script>

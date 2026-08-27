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

    $mapImageWidth = 0;
    $mapImageHeight = 0;
    if ($mapImageId) {
        $mapImageMeta = wp_get_attachment_image_src($mapImageId, 'full');
        $mapImageWidth = $mapImageMeta[1] ?? 0;
        $mapImageHeight = $mapImageMeta[2] ?? 0;
    }

    $showZoomControls = $block['data']['show_zoom_controls'] ?? true;

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
                    @if ($showZoomControls)
                        <div class="kaart-zoom-controls">
                            <button type="button" class="kaart-zoom-btn" data-kaart-zoom-in aria-label="Inzoomen">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="button" class="kaart-zoom-btn" data-kaart-zoom-out aria-label="Uitzoomen">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <button type="button" class="kaart-zoom-btn" data-kaart-zoom-reset aria-label="Zoom resetten">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </button>
                        </div>
                    @endif

                    <div class="kaart-viewport relative w-full overflow-hidden" data-kaart-viewport
                         @if ($mapImageWidth && $mapImageHeight) style="aspect-ratio: {{ $mapImageWidth }} / {{ $mapImageHeight }};" @endif>
                        <div class="kaart-zoom-content relative w-full h-full" data-kaart-zoom-content>
                            @include('components.image', [
                                'image_id' => $mapImageId,
                                'size' => 'full',
                                'object_fit' => 'cover',
                                'class' => 'block w-full h-full',
                                'img_class' => 'w-full h-full select-none pointer-events-none rounded-' . $borderRadius,
                                'alt' => $title ?: 'Vestigingenkaart',
                            ])

                            @foreach ($pinsData as $pinData)
                                <button
                                    type="button"
                                    class="kaart-pin absolute bg-{{ $pinData['color'] }}"
                                    style="left: {{ $pinData['x'] }}%; top: {{ $pinData['y'] }}%;"
                                    data-pin-index="{{ $pinData['id'] }}"
                                    aria-label="{{ $pinData['name'] }}"
                                >
                                    <span class="kaart-pin-label bg-{{ $pinData['color'] }} @if($pinData['labelColor']) text-{{ $pinData['labelColor'] }} @else default-label-color @endif">{{ $pinData['name'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

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
    /* Positionering hieronder bewust expliciet i.p.v. via Tailwind's absolute/relative
       utility-classes, omdat die op dit dynamisch geïnjecteerde blok niet betrouwbaar
       toegepast bleken te worden. */

    #{{ $mapId }}.vestigingen-kaart-map {
        position: relative;
        width: 100%;
    }

    #{{ $mapId }} .kaart-viewport {
        position: relative;
        width: 100%;
        overflow: hidden;
        cursor: grab;
        touch-action: none;
        background: #f2f2f2;
    }

    #{{ $mapId }} .kaart-viewport.is-panning {
        cursor: grabbing;
    }

    #{{ $mapId }} .kaart-zoom-content {
        position: relative;
        width: 100%;
        height: 100%;
        transform-origin: 0 0;
        will-change: transform;
    }

    #{{ $mapId }} .kaart-zoom-controls {
        position: absolute;
        z-index: 30;
        bottom: 12px;
        right: 12px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        pointer-events: auto;
    }

    #{{ $mapId }} .kaart-zoom-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #fff;
        border: none;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
        font-size: 13px;
        cursor: pointer;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    #{{ $mapId }} .kaart-zoom-btn:hover {
        background: #f0f0f0;
    }

    #{{ $mapId }} .kaart-zoom-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    #{{ $mapId }} .kaart-pin {
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 9999px;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.35);
        cursor: pointer;
        padding: 0;
        transition: transform 0.15s ease-in-out;
        /* Tegengesteld aan de kaart-zoom geschaald (via JS bijgewerkt), zodat de pin altijd
           even groot en scherp blijft, ongeacht het zoomniveau van de kaart. */
        transform: translate(-50%, -50%) scale(var(--kaart-pin-scale, 1));
        transform-origin: center;
    }

    #{{ $mapId }} .kaart-pin:hover,
    #{{ $mapId }} .kaart-pin:focus-visible {
        transform: translate(-50%, -50%) scale(calc(var(--kaart-pin-scale, 1) * 1.15));
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
        position: fixed;
        z-index: 200;
        top: 0;
        left: 0;
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
        var viewport = mapEl.querySelector('[data-kaart-viewport]');
        var content = mapEl.querySelector('[data-kaart-zoom-content]');
        var zoomInBtn = mapEl.querySelector('[data-kaart-zoom-in]');
        var zoomOutBtn = mapEl.querySelector('[data-kaart-zoom-out]');
        var zoomResetBtn = mapEl.querySelector('[data-kaart-zoom-reset]');

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

        var activePinEl = null;

        function positionPopupAt(pinEl) {
            if (!popup || !pinEl) {
                return;
            }

            // De popup staat "position: fixed" en gebruikt daarom rechtstreeks de
            // viewport-coördinaten van de pin (geen afhankelijkheid van de kaart-container
            // of eventuele zoom/pan-transforms nodig). Deze functie wordt zowel bij het
            // openen van de popup aangeroepen, als telkens wanneer er gezoomd/gepand wordt
            // terwijl de popup open staat, zodat hij bij de pin blijft "plakken".
            var pinRect = pinEl.getBoundingClientRect();
            var left = pinRect.left + pinRect.width / 2;
            var top = pinRect.top;

            var horizontal = left > window.innerWidth * 0.6
                ? 'translate(-100%, -110%)'
                : (left < window.innerWidth * 0.15 ? 'translate(0, -110%)' : 'translate(-50%, -110%)');

            popup.style.left = left + 'px';
            popup.style.top = top + 'px';
            popup.style.transform = horizontal;
        }

        function openPopup(pin, pinEl) {
            if (!popup || !popupContent) {
                return;
            }

            popupContent.innerHTML = pin.items.map(renderItem).join('');
            popup.classList.remove('hidden');
            activePinEl = pinEl;
            positionPopupAt(pinEl);
        }

        // Zoom & pan: afbeelding en pins zitten samen in "kaart-zoom-content" en krijgen
        // dezelfde transform, zodat de pins (die met % gepositioneerd zijn) altijd correct
        // op de kaart blijven staan, ongeacht het zoomniveau.
        var canZoomPan = viewport ? !!content : false;
        if (canZoomPan) {
            var scale = 1;
            var minScale = 1;
            var maxScale = 4;
            var tx = 0;
            var ty = 0;
            var isPanning = false;
            var hasPanned = false;
            var panStartX = 0;
            var panStartY = 0;
            var panStartTx = 0;
            var panStartTy = 0;

            function clampPan() {
                var vw = viewport.clientWidth;
                var vh = viewport.clientHeight;
                var minTx = Math.min(0, vw - vw * scale);
                var minTy = Math.min(0, vh - vh * scale);
                tx = Math.min(0, Math.max(minTx, tx));
                ty = Math.min(0, Math.max(minTy, ty));
            }

            function applyTransform() {
                content.style.transform = 'translate(' + tx + 'px, ' + ty + 'px) scale(' + scale + ')';

                // Pins tegengesteld schalen zodat ze altijd even groot en scherp blijven,
                // ongeacht het zoomniveau van de kaart zelf.
                var pinScale = 1 / scale;
                var pinEls = content.querySelectorAll('.kaart-pin');
                for (var i = 0; i < pinEls.length; i++) {
                    pinEls[i].style.setProperty('--kaart-pin-scale', pinScale);
                }

                // Popup mee laten bewegen met de pin zolang die open staat.
                if (activePinEl) {
                    if (!popup.classList.contains('hidden')) {
                        positionPopupAt(activePinEl);
                    }
                }
            }

            function updateZoomState() {
                if (zoomOutBtn) {
                    zoomOutBtn.disabled = scale <= minScale;
                }
                if (zoomInBtn) {
                    zoomInBtn.disabled = scale >= maxScale;
                }
                viewport.classList.toggle('is-zoomed', scale > minScale);
            }

            function setScale(newScale, originX, originY) {
                newScale = Math.min(maxScale, Math.max(minScale, newScale));
                if (newScale === scale) {
                    return;
                }

                var vw = viewport.clientWidth;
                var vh = viewport.clientHeight;
                if (typeof originX !== 'number') {
                    originX = vw / 2;
                }
                if (typeof originY !== 'number') {
                    originY = vh / 2;
                }

                var contentX = (originX - tx) / scale;
                var contentY = (originY - ty) / scale;

                scale = newScale;
                tx = originX - contentX * scale;
                ty = originY - contentY * scale;

                if (scale <= minScale) {
                    tx = 0;
                    ty = 0;
                }

                clampPan();
                applyTransform();
                updateZoomState();
            }

            if (zoomInBtn) {
                zoomInBtn.addEventListener('click', function () {
                    setScale(scale + 0.5);
                });
            }

            if (zoomOutBtn) {
                zoomOutBtn.addEventListener('click', function () {
                    setScale(scale - 0.5);
                });
            }

            if (zoomResetBtn) {
                zoomResetBtn.addEventListener('click', function () {
                    setScale(1);
                });
            }

            viewport.addEventListener('wheel', function (event) {
                event.preventDefault();
                var rect = viewport.getBoundingClientRect();
                var originX = event.clientX - rect.left;
                var originY = event.clientY - rect.top;
                var delta = event.deltaY < 0 ? 0.35 : -0.35;
                setScale(scale + delta, originX, originY);
            }, { passive: false });

            viewport.addEventListener('mousedown', function (event) {
                if (scale <= minScale) {
                    return;
                }
                isPanning = true;
                hasPanned = false;
                panStartX = event.clientX;
                panStartY = event.clientY;
                panStartTx = tx;
                panStartTy = ty;
                viewport.classList.add('is-panning');
            });

            window.addEventListener('mousemove', function (event) {
                if (!isPanning) {
                    return;
                }
                var dx = event.clientX - panStartX;
                var dy = event.clientY - panStartY;
                if (Math.abs(dx) > 3 || Math.abs(dy) > 3) {
                    hasPanned = true;
                }
                tx = panStartTx + dx;
                ty = panStartTy + dy;
                clampPan();
                applyTransform();
            });

            window.addEventListener('mouseup', function () {
                if (isPanning) {
                    isPanning = false;
                    viewport.classList.remove('is-panning');
                }
            });

            // Voorkom dat het loslaten van een sleepbeweging op een pin per ongeluk de
            // popup opent.
            viewport.addEventListener('click', function (event) {
                if (hasPanned) {
                    event.stopPropagation();
                    event.preventDefault();
                    hasPanned = false;
                }
            }, true);

            var touchStartDistance = 0;
            var touchStartScale = 1;
            var touchLastX = 0;
            var touchLastY = 0;

            function getTouchDistance(touches) {
                var dx = touches[0].clientX - touches[1].clientX;
                var dy = touches[0].clientY - touches[1].clientY;
                return Math.sqrt(dx * dx + dy * dy);
            }

            viewport.addEventListener('touchstart', function (event) {
                if (event.touches.length === 2) {
                    touchStartDistance = getTouchDistance(event.touches);
                    touchStartScale = scale;
                } else if (event.touches.length === 1) {
                    if (scale > minScale) {
                        isPanning = true;
                        touchLastX = event.touches[0].clientX;
                        touchLastY = event.touches[0].clientY;
                        panStartTx = tx;
                        panStartTy = ty;
                    }
                }
            }, { passive: true });

            viewport.addEventListener('touchmove', function (event) {
                if (event.touches.length === 2) {
                    event.preventDefault();
                    var newDistance = getTouchDistance(event.touches);
                    var rect = viewport.getBoundingClientRect();
                    var midX = (event.touches[0].clientX + event.touches[1].clientX) / 2 - rect.left;
                    var midY = (event.touches[0].clientY + event.touches[1].clientY) / 2 - rect.top;
                    setScale(touchStartScale * (newDistance / touchStartDistance), midX, midY);
                } else if (event.touches.length === 1) {
                    if (isPanning) {
                        event.preventDefault();
                        tx = panStartTx + (event.touches[0].clientX - touchLastX);
                        ty = panStartTy + (event.touches[0].clientY - touchLastY);
                        clampPan();
                        applyTransform();
                    }
                }
            }, { passive: false });

            viewport.addEventListener('touchend', function () {
                isPanning = false;
            });

            updateZoomState();
        }

        mapEl.querySelectorAll('.kaart-pin').forEach(function (pinEl) {
            pinEl.addEventListener('click', function (event) {
                event.stopPropagation();
                var index = parseInt(pinEl.getAttribute('data-pin-index'), 10);
                var pin = pins.find(function (p) { return p.id === index; });
                if (pin) {
                    openPopup(pin, pinEl);
                }
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                popup.classList.add('hidden');
                activePinEl = null;
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
            activePinEl = null;
        });
    });
</script>

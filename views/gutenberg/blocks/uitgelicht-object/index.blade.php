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
        $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $textClassMap[$textPosition] ?? '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Paddings & margins
    $randomNumber = rand(0, 1000);

    $mobilePaddingTop = $block['data']['padding_mobile_padding_top'] ?? '';
    $mobilePaddingRight = $block['data']['padding_mobile_padding_right'] ?? '';
    $mobilePaddingBottom = $block['data']['padding_mobile_padding_bottom'] ?? '';
    $mobilePaddingLeft = $block['data']['padding_mobile_padding_left'] ?? '';
    $tabletPaddingTop = $block['data']['padding_tablet_padding_top'] ?? '';
    $tabletPaddingRight = $block['data']['padding_tablet_padding_right'] ?? '';
    $tabletPaddingBottom = $block['data']['padding_tablet_padding_bottom'] ?? '';
    $tabletPaddingLeft = $block['data']['padding_tablet_padding_left'] ?? '';
    $desktopPaddingTop = $block['data']['padding_desktop_padding_top'] ?? '';
    $desktopPaddingRight = $block['data']['padding_desktop_padding_right'] ?? '';
    $desktopPaddingBottom = $block['data']['padding_desktop_padding_bottom'] ?? '';
    $desktopPaddingLeft = $block['data']['padding_desktop_padding_left'] ?? '';

    $mobileMarginTop = $block['data']['margin_mobile_margin_top'] ?? '';
    $mobileMarginRight = $block['data']['margin_mobile_margin_right'] ?? '';
    $mobileMarginBottom = $block['data']['margin_mobile_margin_bottom'] ?? '';
    $mobileMarginLeft = $block['data']['margin_mobile_margin_left'] ?? '';
    $tabletMarginTop = $block['data']['margin_tablet_margin_top'] ?? '';
    $tabletMarginRight = $block['data']['margin_tablet_margin_right'] ?? '';
    $tabletMarginBottom = $block['data']['margin_tablet_margin_bottom'] ?? '';
    $tabletMarginLeft = $block['data']['margin_tablet_margin_left'] ?? '';
    $desktopMarginTop = $block['data']['margin_desktop_margin_top'] ?? '';
    $desktopMarginRight = $block['data']['margin_desktop_margin_right'] ?? '';
    $desktopMarginBottom = $block['data']['margin_desktop_margin_bottom'] ?? '';
    $desktopMarginLeft = $block['data']['margin_desktop_margin_left'] ?? '';


    // Animaties
    $titleAnimation = $block['data']['title_animation'] ?? false;
    $flyInAnimation = $block['data']['flyin_animation'] ?? false;
    $textFadeDirection = $block['data']['flyin_direction'] ?? 'bottom';

    // 3D Model
    // 3D Model — fallback naar Hatzmann Scania als geen model geüpload is
    $model3dId  = $block['data']['model_3d'] ?? '';
    $modelUrl   = $model3dId
        ? wp_get_attachment_url((int) $model3dId)
        : get_stylesheet_directory_uri() . '/assets/models/hatzmann/Hatzmann.optimized.glb';

    // Object hoogte
    $mobileHeight  = $block['data']['object_height_mobile']  ?: 400;
    $tabletHeight  = $block['data']['object_height_tablet']  ?: 500;
    $desktopHeight = $block['data']['object_height_desktop'] ?: 600;

    // Pinpoints — posities zijn in world units t.o.v. het model-middelpunt (0,0,0)
    $pinpoints = [];
    $pinpointCount = (int)($block['data']['pinpoints'] ?? 0);
    for ($i = 0; $i < $pinpointCount; $i++) {
        $label = get_field("pinpoints_{$i}_label");
        if (!empty($label)) {
            $pinpoints[] = [
                'label' => $label,
                'text'  => get_field("pinpoints_{$i}_text") ?? '',
                'x'     => (float)(get_field("pinpoints_{$i}_pos_x") ?? 0),
                'y'     => (float)(get_field("pinpoints_{$i}_pos_y") ?? 0),
                'z'     => (float)(get_field("pinpoints_{$i}_pos_z") ?? 0),
            ];
        }
    }
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'uitgelicht-object' }}@endif" class="block-uitgelicht-object block-{{ $randomNumber }} relative uitgelicht-object-{{ $randomNumber }}-custom-padding uitgelicht-object-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="content-background flex-col lg:flex-row {{ $blockClass }} mx-auto {{ $textClass }}">
            <div class="text-section">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">
                        @if ($subtitleIcon)
                            <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                        @endif
                        {!! $subTitle !!}
                    </span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">{!! $title !!}</h2>
                @endif
                @if ($text)
                    @include('components.content', [
                        'content' => apply_filters('the_content', $text),
                        'class' => 'mb-8 text-' . $textColor . ($flyInAnimation ? ' flyin-animation' : ''),
                    ])
                @endif

                    @if (($button1Text) && ($button1Link))
                        <div class="{{ $textClass }} buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 @if ($flyInAnimation) flyin-animation @endif">
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

            <div class="object-section uitgelicht-object-{{ $randomNumber }}-canvas-height">
                <div class="threejs-wrapper threejs-{{ $randomNumber }} w-full h-full relative">
                    <div id="threejs-canvas-{{ $randomNumber }}" class="w-full h-full"></div>

                    {{-- Rotatie pijlen links en rechts (zelfde stijl als .swiper-button-prev/next) --}}
                    <button id="rotate-left-{{ $randomNumber }}" aria-label="Naar links draaien"
                            class="absolute top-1/2 flex items-center justify-center bg-white hover:bg-primary group transition-colors rounded-none"
                            style="transform: translateY(-50%); left: 0; width: 52px; height: 52px; z-index: 30; border: none; cursor: pointer;">
                        <i class="fa-regular fa-chevron-left text-[24px] text-primary group-hover:text-white"></i>
                    </button>
                    <button id="rotate-right-{{ $randomNumber }}" aria-label="Naar rechts draaien"
                            class="absolute top-1/2 flex items-center justify-center bg-white hover:bg-primary group transition-colors rounded-none"
                            style="transform: translateY(-50%); right: 0; width: 52px; height: 52px; z-index: 30; border: none; cursor: pointer;">
                        <i class="fa-regular fa-chevron-right text-[24px] text-primary group-hover:text-white"></i>
                    </button>

                    {{-- Loading indicator --}}
                    <div id="threejs-loader-{{ $randomNumber }}" class="absolute inset-0 flex flex-col items-center justify-center gap-3" style="z-index: 40;">
                        <div class="threejs-spinner"></div>
                        <span class="text-sm font-medium" style="color: var(--primary-color, #1e3a8a); opacity: 0.6;">3D model laden…</span>
                    </div>

                    {{-- Pinpoint popup --}}
                    <div id="pinpoint-popup-{{ $randomNumber }}"
                         class="absolute hidden"
                         style="transform: translate(-50%, calc(-100% - 14px)); pointer-events: none; z-index: 50;">
                        <div class="bg-white shadow-xl p-4 relative" style="width: 240px; pointer-events: auto;">
                            <button class="pinpoint-popup-close absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl leading-none">&times;</button>
                            <div class="pinpoint-popup-title text-primary text-[20px] font-semibold pr-5 mb-1"></div>
                            <div class="pinpoint-popup-text text-primary text-[14px] leading-relaxed"></div>
                        </div>
                        <div class="absolute left-1/2" style="bottom: -8px; transform: translateX(-50%); width:0; height:0; border-left:8px solid transparent; border-right:8px solid transparent; border-top:8px solid white;"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

<style>
    .uitgelicht-object-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($mobilePaddingTop) padding-top: {{ $mobilePaddingTop }}px; @endif
            @if($mobilePaddingRight) padding-right: {{ $mobilePaddingRight }}px; @endif
            @if($mobilePaddingBottom) padding-bottom: {{ $mobilePaddingBottom }}px; @endif
            @if($mobilePaddingLeft) padding-left: {{ $mobilePaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletPaddingTop) padding-top: {{ $tabletPaddingTop }}px; @endif
            @if($tabletPaddingRight) padding-right: {{ $tabletPaddingRight }}px; @endif
            @if($tabletPaddingBottom) padding-bottom: {{ $tabletPaddingBottom }}px; @endif
            @if($tabletPaddingLeft) padding-left: {{ $tabletPaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopPaddingTop) padding-top: {{ $desktopPaddingTop }}px; @endif
            @if($desktopPaddingRight) padding-right: {{ $desktopPaddingRight }}px; @endif
            @if($desktopPaddingBottom) padding-bottom: {{ $desktopPaddingBottom }}px; @endif
            @if($desktopPaddingLeft) padding-left: {{ $desktopPaddingLeft }}px; @endif
        }
    }

    .uitgelicht-object-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($mobileMarginTop) margin-top: {{ $mobileMarginTop }}px; @endif
            @if($mobileMarginRight) margin-right: {{ $mobileMarginRight }}px; @endif
            @if($mobileMarginBottom) margin-bottom: {{ $mobileMarginBottom }}px; @endif
            @if($mobileMarginLeft) margin-left: {{ $mobileMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletMarginTop) margin-top: {{ $tabletMarginTop }}px; @endif
            @if($tabletMarginRight) margin-right: {{ $tabletMarginRight }}px; @endif
            @if($tabletMarginBottom) margin-bottom: {{ $tabletMarginBottom }}px; @endif
            @if($tabletMarginLeft) margin-left: {{ $tabletMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopMarginTop) margin-top: {{ $desktopMarginTop }}px; @endif
            @if($desktopMarginRight) margin-right: {{ $desktopMarginRight }}px; @endif
            @if($desktopMarginBottom) margin-bottom: {{ $desktopMarginBottom }}px; @endif
            @if($desktopMarginLeft) margin-left: {{ $desktopMarginLeft }}px; @endif
        }
    }

    @keyframes uitgelicht-spin-{{ $randomNumber }} {
        to { transform: rotate(360deg); }
    }
    #threejs-loader-{{ $randomNumber }} .threejs-spinner {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 4px solid rgba(0,0,0,0.08);
        border-top-color: var(--cta-color, #1a56db);
        animation: uitgelicht-spin-{{ $randomNumber }} 0.8s linear infinite;
    }
    #threejs-loader-{{ $randomNumber }}.hidden {
        display: none;
    }


    .uitgelicht-object-{{ $randomNumber }}-canvas-height {
        @media only screen and (min-width: 0px) {
            height: {{ $mobileHeight }}px;
        }
        @media only screen and (min-width: 768px) {
            height: {{ $tabletHeight }}px;
        }
        @media only screen and (min-width: 1024px) {
            height: {{ $desktopHeight }}px;
        }
    }
</style>

@if ($titleAnimation)
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            gsap.registerPlugin(ScrollTrigger);

            document.querySelectorAll('.title-animation').forEach(element => {
                let typeSplit = new SplitType(element, {
                    types: 'lines, words, chars',
                    tagName: 'span'
                });

                gsap.from(element.querySelectorAll('.word'), {
                    y: '100%',
                    opacity: 0,
                    duration: 0.5,
                    ease: 'back',
                    stagger: 0.1,
                    scrollTrigger: {
                        trigger: element, // The current element that triggers the animation
                        start: 'top 70%', // When the trigger element is 70% from the top of the viewport
                        end: 'top 50%', // Animation end point
                        scrub: true, // If set to false, the animation will not synchronize with the scrollbar
                        once: false, // Ensures the animation triggers only once
                        markers: false // Disable markers for production
                    }
                });
            });
        });
    </script>
@endif

@if ($flyInAnimation)
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            gsap.registerPlugin(ScrollTrigger);

            const randomNumber = @json($randomNumber);
            const block = document.querySelector(`.block-${randomNumber}`);

            if (block) {
                block.querySelectorAll('.flyin-animation').forEach(element => {
                    let typeSplit = new SplitType(element, {
                        types: 'lines',
                        tagName: 'span'
                    });

                    var fadeDirection = @json($textFadeDirection);
                    let xValue, yValue;

                    if (fadeDirection === "left") {
                        xValue = '-20%';
                    } else if (fadeDirection === "right") {
                        xValue = '20%';
                    } else {
                        xValue = '0%';
                    }

                    if (fadeDirection === "top") {
                        yValue = '-20%';
                    } else if (fadeDirection === "bottom") {
                        yValue = '20%';
                    } else {
                        yValue = '0%';
                    }

                    gsap.from(element.querySelectorAll('.line'), {
                        x: xValue,
                        y: yValue,
                        opacity: 0,
                        duration: 1.5,
                        ease: 'power4.out',
                        stagger: 0,
                        scrollTrigger: {
                            trigger: element, // The current element that triggers the animation
                            start: 'top 65%', // When the trigger element is 60% from the top of the viewport
                            end: 'top 50%', // Animation end point
                            scrub: false, // If set to false, the animation will not synchronize with the scrollbar
                            once: true, // Ensures the animation triggers only once
                            markers: false // Disable markers for production
                        }
                    });
                });
            }
        });
    </script>
@endif

<script type="module">
    import * as THREE from "https://esm.sh/three@0.129.0";
    import { OrbitControls } from "https://esm.sh/three@0.129.0/examples/jsm/controls/OrbitControls";
    import { GLTFLoader } from "https://esm.sh/three@0.129.0/examples/jsm/loaders/GLTFLoader";
    import { DRACOLoader } from "https://esm.sh/three@0.129.0/examples/jsm/loaders/DRACOLoader";
    import { RoomEnvironment } from "https://esm.sh/three@0.129.0/examples/jsm/environments/RoomEnvironment";

    const container = document.getElementById('threejs-canvas-{{ $randomNumber }}');
    if (!container) { console.warn('Three.js container not found for block {{ $randomNumber }}'); } else {

    // Lazy load: initialiseer Three.js pas als het blok in de viewport komt
    const observer = new IntersectionObserver((entries, obs) => {
        if (!entries[0].isIntersecting) return;
        obs.disconnect();
        initScene();
    }, { rootMargin: '200px' }); // 200px voor de rand alvast beginnen laden
    observer.observe(container);

    function initScene() {

    const isMobile = window.innerWidth < 768 || /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);

    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: !isMobile });
    renderer.setPixelRatio(isMobile ? 1 : Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = !isMobile;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = isMobile ? THREE.LinearToneMapping : THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.1;
    renderer.outputEncoding = THREE.sRGBEncoding;
    renderer.domElement.style.touchAction = 'none';
    container.appendChild(renderer.domElement);

    const pmrem = new THREE.PMREMGenerator(renderer);
    const envTex = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;
    scene.environment = envTex;

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.enableZoom = false; // Standaard zoom uit voor betere pagina-scroll

    // Onderkant geblokkeerd: camera mag niet onder de horizon (PI/2 = 90°)
    controls.maxPolarAngle = Math.PI / 2;

    // Auto-rotatie: model draait langzaam totdat gebruiker het aanraakt
    controls.autoRotate = true;
    controls.autoRotateSpeed = 1.2;

    // Stoppen met auto-roteren zodra gebruiker interacteert
    renderer.domElement.addEventListener('pointerdown', () => {
        controls.autoRotate = false;
    }, { once: true });

    // Zoom activeren bij interactie (klik/touch)
    renderer.domElement.addEventListener('pointerdown', () => {
        controls.enableZoom = true;
    });

    // Zoom deactiveren wanneer de muis de container verlaat
    container.addEventListener('mouseleave', () => {
        controls.enableZoom = false;
    });

    // Rotatie-knoppen: 30° per klik draaien
    function rotateCamera(direction) {
        const spherical = new THREE.Spherical();
        const offset = camera.position.clone().sub(controls.target);
        spherical.setFromVector3(offset);
        spherical.theta += direction * (Math.PI / 6); // 30°
        offset.setFromSpherical(spherical);
        camera.position.copy(controls.target).add(offset);
        camera.lookAt(controls.target);
        controls.update();
        requestRender();
    }
    const rotateBtnLeft  = document.getElementById('rotate-left-{{ $randomNumber }}');
    const rotateBtnRight = document.getElementById('rotate-right-{{ $randomNumber }}');
    if (rotateBtnLeft)  rotateBtnLeft.addEventListener('click',  (e) => { e.stopPropagation(); rotateCamera(1);  });
    if (rotateBtnRight) rotateBtnRight.addEventListener('click', (e) => { e.stopPropagation(); rotateCamera(-1); });

    // Key lights with soft shadows
    const dir = new THREE.DirectionalLight(0xffffff, 1.4);
    dir.position.set(6, 8, 6);
    dir.castShadow = true;
    dir.shadow.mapSize.set(2048, 2048);
    dir.shadow.camera.near = 1;
    dir.shadow.camera.far = 50;
    dir.shadow.camera.left = -10;
    dir.shadow.camera.right = 10;
    dir.shadow.camera.top = 10;
    dir.shadow.camera.bottom = -10;
    scene.add(dir);

    const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 0.6);
    hemi.position.set(0, 1, 0);
    scene.add(hemi);

    let object;
    const pinpointMeshes = [];
    let activePinSprite = null;
    let hoveredSprite = null;
    let pinBaseScale = 1;
    const popup = document.getElementById('pinpoint-popup-{{ $randomNumber }}');
    const raycaster = new THREE.Raycaster();
    const pinpointDefs = @json($pinpoints);

    const ctaColor = getComputedStyle(document.documentElement).getPropertyValue('--cta-color').trim() || '#facc15';

    function createPinTex(isActive) {
        const c = document.createElement('canvas');
        c.width = c.height = 128;
        const ctx = c.getContext('2d');

        // Drop shadow
        ctx.shadowColor = 'rgba(0,0,0,0.28)';
        ctx.shadowBlur = 10;
        ctx.shadowOffsetY = 2;

        // Outer ring: wit (active) of lichtgrijs (inactive)
        ctx.beginPath();
        ctx.arc(64, 64, 58, 0, Math.PI * 2);
        ctx.fillStyle = isActive ? '#ffffff' : '#d1d5db';
        ctx.fill();
        ctx.shadowBlur = 0; ctx.shadowOffsetY = 0;

        // Gekleurde cirkel: donkerblauw (active) of medium blauw (inactive)
        ctx.beginPath();
        ctx.arc(64, 64, 46, 0, Math.PI * 2);
        ctx.fillStyle = isActive ? '#1e3a8a' : '#5b7db5';
        ctx.fill();

        // Center dot: cta kleur (active) of wit (inactive)
        ctx.beginPath();
        ctx.arc(64, 64, 17, 0, Math.PI * 2);
        ctx.fillStyle = isActive ? ctaColor : '#ffffff';
        ctx.fill();

        return new THREE.CanvasTexture(c);
    }
    const pinTex       = createPinTex(false);
    const pinTexActive = createPinTex(true);

    const dracoLoader = new DRACOLoader();
    dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');

    const loader = new GLTFLoader();
    loader.setDRACOLoader(dracoLoader);

    const modelUrl = '{{ $modelUrl }}';

    const loaderEl = document.getElementById('threejs-loader-{{ $randomNumber }}');

    loader.load(
        modelUrl,
        (gltf) => {
            object = gltf.scene;
            object.traverse(child => {
                if (child.isMesh) { child.castShadow = true; child.receiveShadow = true; }
            });
            scene.add(object);
            if (loaderEl) loaderEl.classList.add('hidden');

            resizeToContainer();
            try {
                const box = new THREE.Box3().setFromObject(object);
                const size = new THREE.Vector3();
                const center = new THREE.Vector3();
                box.getSize(size);
                box.getCenter(center);

                object.position.x += (object.position.x - center.x);
                object.position.y += (object.position.y - center.y);
                object.position.z += (object.position.z - center.z);

                const maxDim = Math.max(size.x, size.y, size.z);
                const fov = camera.fov * (Math.PI / 180);
                let cameraZ = Math.abs(maxDim / 2 / Math.tan(fov / 2));
                cameraZ *= 1.05;
                camera.position.set(0, 0, cameraZ);
                camera.near = cameraZ / 100;
                camera.far = cameraZ * 100;
                camera.updateProjectionMatrix();

                controls.target.set(0, 0, 0);

                // Max zoom: niet verder inzoomen dan 60% van de standaard cameraafstand
                controls.minDistance = cameraZ * 0.6;
                // Min zoom: niet verder uitzoomen dan 2.5x de standaard cameraafstand
                controls.maxDistance = cameraZ * 2.5;

                controls.update();

                // Pinpoints aanmaken na centreren van het model
                pinBaseScale = maxDim * 0.10;
                // console.log('[Uitgelicht Object] Model bounds — size:', JSON.stringify({x: size.x.toFixed(2), y: size.y.toFixed(2), z: size.z.toFixed(2)}), '| Gebruik deze waarden om pinpoint posities in te stellen t.o.v. middelpunt (0,0,0).');
                pinpointDefs.forEach((def, idx) => {
                    const mat = new THREE.SpriteMaterial({ map: pinTex, depthTest: false, transparent: true });
                    const sprite = new THREE.Sprite(mat);
                    sprite.scale.setScalar(pinBaseScale);
                    sprite.position.set(def.x, def.y, def.z);
                    sprite.userData = { pinData: def, idx };
                    sprite.renderOrder = 999;
                    scene.add(sprite);
                    pinpointMeshes.push(sprite);
                });
            } catch (e) {
                console.warn('Model framing failed:', e);
            }
        },
        (xhr) => { /* progress — optioneel */ },
        (err) => {
            console.error(err);
            if (loaderEl) {
                loaderEl.querySelector('.threejs-spinner').style.display = 'none';
                loaderEl.querySelector('span').textContent = 'Model kon niet worden geladen.';
            }
        }
    );

    function resizeToContainer() {
        const width = container.clientWidth || container.offsetWidth || 0;
        const height = container.clientHeight || container.offsetHeight || 0;
        if (width > 0 && height > 0) {
            renderer.setSize(width, height, true);
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
        }
    }

    requestAnimationFrame(() => resizeToContainer());
    window.addEventListener('resize', resizeToContainer);
    if ('ResizeObserver' in window) {
        const ro = new ResizeObserver(resizeToContainer);
        ro.observe(container);
    }

    // Popup positie bijwerken op basis van 3D→2D projectie
    function updatePopupPos() {
        if (!activePinSprite || !popup || popup.classList.contains('hidden')) return;
        const wp = new THREE.Vector3();
        activePinSprite.getWorldPosition(wp);
        wp.project(camera);
        popup.style.left = ((wp.x * 0.5 + 0.5) * container.clientWidth) + 'px';
        popup.style.top  = ((-wp.y * 0.5 + 0.5) * container.clientHeight) + 'px';
    }

    function deactivatePin() {
        if (activePinSprite) {
            activePinSprite.material.map = pinTex;
            activePinSprite.material.needsUpdate = true;
            activePinSprite = null;
        }
        if (popup) popup.classList.add('hidden');
    }

    if (popup) {
        popup.querySelector('.pinpoint-popup-close').addEventListener('click', () => {
            deactivatePin();
        });
    }

    // Tap/click detectie voor muis én touch
    // Pointer-positie bijhouden bij pointerdown zodat we tap van drag kunnen onderscheiden
    let pointerDownX = 0, pointerDownY = 0;

    function handleTap(clientX, clientY) {
        if (!pinpointMeshes.length || !popup) return;
        const rect = container.getBoundingClientRect();
        const mouse = new THREE.Vector2(
            ((clientX - rect.left) / rect.width) * 2 - 1,
            -((clientY - rect.top) / rect.height) * 2 + 1
        );
        raycaster.setFromCamera(mouse, camera);
        const hits = raycaster.intersectObjects(pinpointMeshes);
        if (hits.length > 0) {
            deactivatePin();
            activePinSprite = hits[0].object;
            activePinSprite.material.map = pinTexActive;
            activePinSprite.material.needsUpdate = true;
            const d = activePinSprite.userData.pinData;
            popup.querySelector('.pinpoint-popup-title').textContent = d.label;
            popup.querySelector('.pinpoint-popup-text').textContent  = d.text;
            popup.classList.remove('hidden');
            updatePopupPos();
        }
    }

    container.addEventListener('pointerdown', (e) => {
        pointerDownX = e.clientX;
        pointerDownY = e.clientY;
    });

    container.addEventListener('pointerup', (e) => {
        const dx = e.clientX - pointerDownX;
        const dy = e.clientY - pointerDownY;
        // Alleen als pointer nauwelijks bewogen is (tap, geen drag/rotate)
        if (Math.sqrt(dx * dx + dy * dy) < 8) {
            handleTap(e.clientX, e.clientY);
        }
    });

    container.addEventListener('mousemove', (e) => {
        if (!pinpointMeshes.length) return;
        const rect = container.getBoundingClientRect();
        const mouse = new THREE.Vector2(
            ((e.clientX - rect.left) / rect.width) * 2 - 1,
            -((e.clientY - rect.top) / rect.height) * 2 + 1
        );
        raycaster.setFromCamera(mouse, camera);
        const hoverHits = raycaster.intersectObjects(pinpointMeshes);
        hoveredSprite = hoverHits.length > 0 ? hoverHits[0].object : null;
        container.style.cursor = hoveredSprite ? 'pointer' : '';
    });

    // On-demand rendering: alleen renderen als er iets verandert
    let needsRender = true;
    const requestRender = () => { needsRender = true; };
    controls.addEventListener('change', requestRender);
    controls.addEventListener('start', requestRender);

    // Render triggeren bij interactie
    container.addEventListener('pointerdown', requestRender);
    container.addEventListener('pointermove', requestRender);

    (function animate(){
        requestAnimationFrame(animate);
        controls.update();

        // Pinpoints schaal animeren — check of iets aan het bewegen is
        let animating = false;
        pinpointMeshes.forEach(s => {
            const enlarged = s === activePinSprite || s === hoveredSprite;
            const target = pinBaseScale * (enlarged ? 1.25 : 1.0);
            const diff = target - s.scale.x;
            if (Math.abs(diff) > 0.001) {
                s.scale.setScalar(s.scale.x + diff * 0.15);
                animating = true;
            }
        });

        updatePopupPos();

        if (needsRender || animating || activePinSprite || controls.autoRotate) {
            renderer.render(scene, camera);
            needsRender = false;
        }
    })();

    } // einde initScene()
    } // einde container else
</script>
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
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'uitgelicht-object' }}@endif" class="block-uitgelicht-object block-{{ $randomNumber }} relative uitgelicht-object-{{ $randomNumber }}-custom-padding uitgelicht-object-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="content-background {{ $blockClass }} mx-auto {{ $textClass }}">
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

            <div class="object-section">
                <div class="threejs-wrapper threejs-{{ $randomNumber }} w-full">
                    <div id="threejs-canvas-{{ $randomNumber }}" class="w-full" style="height: 500px; max-height: 70vh;"></div>
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
    import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
    import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";
    import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";
    import { RoomEnvironment } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/environments/RoomEnvironment.js";

    const container = document.getElementById('threejs-canvas-{{ $randomNumber }}');
    if (!container) { console.warn('Three.js container not found for block {{ $randomNumber }}'); } else {

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);

    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setPixelRatio(window.devicePixelRatio || 1);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.1;
    renderer.outputEncoding = THREE.sRGBEncoding;
    container.appendChild(renderer.domElement);

    const pmrem = new THREE.PMREMGenerator(renderer);
    const envTex = pmrem.fromScene(new RoomEnvironment(), 0.04).texture;
    scene.environment = envTex;

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

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
    const loader = new GLTFLoader();
    const modelUrl = '{{ get_stylesheet_directory_uri() }}/assets/models/forklift/scene.gltf';

    loader.load(
        modelUrl,
        (gltf) => {
            object = gltf.scene;
            object.traverse(child => {
                if (child.isMesh) { child.castShadow = true; child.receiveShadow = true; }
            });
            scene.add(object);

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
                cameraZ *= 1.5;
                camera.position.set(0, 0, cameraZ);
                camera.near = cameraZ / 100;
                camera.far = cameraZ * 100;
                camera.updateProjectionMatrix();

                controls.target.set(0, 0, 0);
                controls.update();
            } catch (e) {
                console.warn('Model framing failed:', e);
            }
        },
        undefined,
        (err) => console.error(err)
    );

    function resizeToContainer() {
        const width = container.clientWidth || container.offsetWidth || 0;
        const height = container.clientHeight || container.offsetHeight || 0;
        if (width > 0 && height > 0) {
            renderer.setSize(width, height, false);
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

    (function animate(){
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    })();
}
</script>
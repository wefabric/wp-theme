@php
    $options = get_fields('option');
    $btt     = $options['back_to_top'] ?? [];

    if (empty($btt['active'])) return;

    $bgColor   = $btt['bg_color']   ?? 'primary-color';
    $iconColor = $btt['icon_color'] ?? 'white-color';
    $position  = $btt['position']   ?? 'right';
    $style     = $btt['style']      ?? 'rounded';

    // Tailwind klasse opbouwen vanuit de Thema Kleur waarde (bv. 'primary-color' → 'bg-primary')
    $bgClass    = 'bg-'   . str_replace('-color', '', $bgColor);
    $iconClass  = 'text-' . str_replace('-color', '', $iconColor);
    $posClass   = $position === 'left' ? 'left-6' : 'right-6';
    $shapeClass = $style === 'square'  ? 'rounded-xl' : 'rounded-full';
@endphp

<button id="back-to-top"
        class="fixed bottom-8 {{ $posClass }} z-50 w-12 h-12 flex items-center justify-center {{ $bgClass }} {{ $iconClass }} {{ $shapeClass }} shadow-lg cursor-pointer"
        style="opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.2s ease; transform: scale(0.8);"
        aria-label="Terug naar boven">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<script>
(function () {
    var btn = document.getElementById('back-to-top');
    if (!btn) return;

    var SHOW_AFTER = 300; // px vanaf de top waarop de knop verschijnt
    var isVisible  = false;

    function update() {
        var show = window.scrollY > SHOW_AFTER;
        if (show === isVisible) return;
        isVisible            = show;
        btn.style.opacity    = show ? '1'       : '0';
        btn.style.visibility = show ? 'visible' : 'hidden';
        btn.style.transform  = show ? 'scale(1)' : 'scale(0.8)';
    }

    window.addEventListener('scroll', update, { passive: true });
    update(); // controleer direct bij page load (bijv. na refresh halverwege)

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    btn.addEventListener('mouseenter', function () {
        if (isVisible) btn.style.transform = 'scale(1.1)';
    });
    btn.addEventListener('mouseleave', function () {
        if (isVisible) btn.style.transform = 'scale(1)';
    });
})();
</script>

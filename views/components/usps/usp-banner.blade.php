@php
    $min_amount = get_free_shipping_minimum('BeNeDuLux');
@endphp

<div class="bg-tertiary w-full rounded-t-lg">

    <!-- Desktop USP banner -->
    <div class="hidden lg:block usp_banner container mx-auto">
        <ul class="flex text-xs ml-4">
            <li class="usp-item sm:mr-6">
                <i class="text-secondary fas fa-check-circle"></i>
                <strong>Gratis</strong> verzending vanaf <?php echo $min_amount; ?>,-
            </li>
            <li class="usp-item sm:mr-6">
                <i class="text-secondary fas fa-check-circle"></i>
                Vandaag besteld, <strong>morgen</strong> in huis!
            </li>
            <li class="usp-item sm:mr-6">
                <i class="text-secondary fas fa-check-circle"></i>
                Specialist in bevestigingstechnieken
            </li>
        </ul>
    </div>

    <!-- Mobile USP banner -->
    <div class="lg:hidden swiper uspSwiper text-center text-xs py-1">
        <ul class="swiper-wrapper">
            <li class="swiper-slide sm:mr-6">
                <i class="text-secondary fas fa-check-circle"></i>
                <strong>Gratis</strong> verzending vanaf <?php echo $min_amount; ?>,-
            </li>
            <li class="swiper-slide sm:mr-6">
                <i class="text-secondary fas fa-check-circle"></i>
                Vandaag besteld, <strong>morgen</strong> in huis!
            </li>
            <li class="swiper-slide sm:mr-6">
                <i class="text-secondary fas fa-check-circle"></i>
                Specialist in bevestigingstechnieken
            </li>
        </ul>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        const swiper = new Swiper(".uspSwiper", {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 4000
            },
        });
    </script>

</div>




@extends('layouts.main')

@section('content')

	@include('components.breadcrumbs.index')

	<div class="container mx-auto px-8 py-8">
		@php do_action('woocommerce_before_main_content') @endphp

{{--		<header class="woocommerce-products-header">--}}
{{--			@if(apply_filters('woocommerce_show_page_title', true))--}}
{{--				<h1 class="woocommerce-products-header__title page-title">{{ woocommerce_page_title(false) }}</h1>--}}
{{--			@endif--}}
{{--            <div class="mx-auto lg:max-w-4xl px-4 lg:px-0">--}}
{{--					@php do_action('woocommerce_archive_description') @endphp--}}
{{--			</div>--}}

{{--		</header>--}}

		<div class="lg:flex lg:flex-row w-full gap-4 lg:gap-32">
			@if(function_exists('dynamic_sidebar'))
				<div class="sidebar mb-4 lg:mb-8 ">

					<div class="hidden lg:block">
						@include('components.woocommerce.category-tree')
					</div>

                        <?php
                        $buildYearTerms = get_terms([
                            'taxonomy' => 'pa_bouwjaar',
                            'hide_empty' => true
                        ]);
                        $buildYearValues = [];
                        if(!empty($buildYearTerms)) {
                            foreach ($buildYearTerms as $term) {
                                $buildYearValues[] = [
                                    'id' => $term->term_id,
                                    'name' => $term->name
                                ];
                            }
                        }

                        $runTimeTerms = get_terms([
                            'taxonomy' => 'pa_counter1',
                            'hide_empty' => false
                        ]);
                        $runTimeValues = [];
                        if(!empty($runTimeTerms)) {
                            foreach ($runTimeTerms as $runterm) {
                                $runTimeValues[] = $runterm->name;
                            }
                        }


                        function filter_products_by_buildyear($query) {
                            if ( isset($_GET['buildyear']) && !empty($_GET['buildyear']) ) {
                                $selectedYear = sanitize_text_field($_GET['buildyear']);
                                $query->set('tax_query', array(
                                    array(
                                        'taxonomy' => 'pa_bouwjaar',
                                        'field'    => 'slug',
                                        'terms'    => $selectedYear,
                                    )
                                ));
                            }
                        }

                        ?>

                    <div class="hidden lg:block">
                        <h1 class="product-search-filter-terms-heading product-search-filter-attribute-heading">Bouwjaar</h1>
                    <div class="slider-container">
                        <form method="GET">
                            <input type="range" id="buildYearRange" name="buildyear" min="0" max="<?= count($buildYearValues)-1 ?>" value="0">
                            <span id="buildYearValue"><?= $buildYearValues[0]['name'] ?></span>
                            <input type="hidden" id="buildYearTerm" name="ixwpst[taxonomy][pa_bouwjaar][terms][]" value="<?= $buildYearValues[0]['id'] ?>">
                            <input type="hidden" name="ixwpst[taxonomy][pa_bouwjaar][filter]" value="1">
                            <input type="hidden" name="ixwpst[taxonomy][pa_bouwjaar][multiple]" value="1">
                            <button type="submit">Filter</button>
                        </form>
                    </div>
                    </div>
                    <style>
                        .slider-container {
                            width: 300px;
                        }
                        input[type=range] {
                            width: 100%;
                        }
                        .value-display {
                            margin-top: 10px;
                            font-weight: bold;
                        }
                    </style>
                    <script>

                        const slider = document.getElementById("buildYearRange");
                        const output = document.getElementById("buildYearValue");
                        const hiddenTerm = document.getElementById("buildYearTerm");
                        let buildYears = <?= json_encode($buildYearValues); ?>;

                        slider.addEventListener("input", function() {
                            let obj = buildYears[this.value];
                            output.textContent = obj.name;
                            hiddenTerm.value = obj.id;
                        });

                    </script>

                    <div class="hidden lg:block">
                        <h1 class="product-search-filter-terms-heading product-search-filter-attribute-heading">Aantal Gebruikersuren</h1>
                        <div class="slider-container">
                            <input type="range" id="runTimeRange" min="0" max="<?= count($runTimeValues) - 1 ?>" value="0">
                            <div class="value-display">Value: <span id="runtimeValue"><?=  $runTimeValues[0] ?? '' ?></span></div>
                        </div>
                    </div>
                    <style>
                        .slider-container {
                            width: 300px;
                        }
                        input[type=range] {
                            width: 100%;
                        }
                        .value-display {
                            margin-top: 10px;
                            font-weight: bold;
                        }
                    </style>
                    <script>
                        const slider = document.getElementById("runTimeRange");
                        const output = document.getElementById("runtimeValue");

                        let runTime = <?= json_encode($runTimeValues); ?>;
                        slider.addEventListener("input", function() {
                            output.textContent = runTime[index = this.value];
                        });
                    </script>


{{--					<div class="lg:hidden flex flex-row items-center gap-4 px-4 lg:px-0">--}}
{{--						<div class="">--}}
{{--							<span class="btn btn-black show-filters hover:bg-black "><i class="fa-solid fa-sliders"></i> Filters</span>--}}
{{--						</div>--}}
{{--						<div>--}}
{{--							<a class="hover:underline" href="#products-start">Ga naar producten <i class="fa-solid fa-circle-chevron-right pl-1"></i></a>--}}
{{--						</div>--}}
{{--					</div>--}}



					<div class="shop-filters mt-4 lg:mt-0 hidden lg:block w-full">
						<div class="px-4 lg:px-0">
							@php dynamic_sidebar('sidebar-shop') @endphp
						</div>

						<div class="sticky bottom-0 p-4 text-center z-10 w-full bg-white border border-white shadow-md lg:hidden">
							<a href="#products-start" class="btn btn-primary sticky show-products">Toon producten</a>
						</div>

					</div>

					<script>
						jQuery( document ).ready(function($) {
							$('.show-filters').click(function (){
								$('.shop-filters').toggleClass('hidden');
							});
							$('.show-products').click(function (){
								$('.shop-filters').addClass('hidden');
							});

						});
					</script>

				</div>
			@endif

			<div class="px-4 m md:px-8 lg:px-0 w-full lg:w-3/4 shop_content">
				@if(woocommerce_product_loop())
					@php do_action('woocommerce_before_shop_loop') @endphp

					{!! woocommerce_product_loop_start(false) !!}

					@if(wc_get_loop_prop('total'))
						@while(have_posts())
							@php the_post() @endphp

							@php do_action('woocommerce_shop_loop') @endphp
							@php wc_get_template_part('content', 'product') @endphp
						@endwhile
                    @endif

					{!! woocommerce_product_loop_end(false) !!}

					@php do_action('woocommerce_after_shop_loop') @endphp
				@else
					@php do_action('woocommerce_no_products_found') @endphp
				@endif

				@php do_action('woocommerce_after_main_content') @endphp
			</div>
		</div>

        @php
            $postContent = get_post_field('post_content', $page->ID);
        @endphp

        <div class="page-builder">
            {!! apply_filters('the_content', $postContent) !!}
        </div>

	</div>
@endsection

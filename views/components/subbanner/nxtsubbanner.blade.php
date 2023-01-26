@php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); @endphp

<section class="subbanner relative px-4 lg:py-40 md:py-30 sm:py-30">
  @php echo '<div class="image z-1" style="background: url('.esc_url($featured_img_url).') center center; background-size: cover;"></div>'; @endphp
  <div class="container mx-auto flex justify-center items-center relative z-5">
      <div class="mx-auto text-center text-white">
          <div class="breadcrumbs mb-5">
            {!! yoast_breadcrumb() !!}
          </div>
          <h1 class="uppercase">
            @php the_title(); @endphp
          </h1>
      </div>
  </div>
</section>

@extends('layouts.main')

@section('content')
    <div class="header">
        {!! themeHeader()->render($page->ID) !!}
    </div>

    @loop
    <!-- Place styling for news items here -->
        <h1 class="entry-title"><?php the_title(); ?></h1>

        <div class="entry-content">

            <?php the_content(); ?>

        </div>
    @endloop

    <?php the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '<', 'textdomain' ),
        'next_text' => __( '>', 'textdomain' ),
    ) ); ?>

    <div class="page-builder">
        {!! pageBuilder()->render($page->ID) !!}
    </div>
@endsection

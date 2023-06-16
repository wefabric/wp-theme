<?php
/**
 * Block Name: Testimonial
 *
 * This is the template that displays the testimonial block.
 */

// get image field (array)

// create id attribute for specific styling
$id = 'testimonial-' . $block['id'];


?>
<blockquote id="<?php echo $id; ?>" class="testimonial" style="text-align: {{ $block['align_text'] }}">
    <p><?php the_field('testimonial'); ?></p>
    <cite>
        {!! wp_get_attachment_image(get_field('avatar')) !!}
        <span><?php the_field('author'); ?></span>
    </cite>
</blockquote>
<?php
    $randomNumber = rand(0, 1000);
    $template = $block['data']['template'] ?? 'default';
?>

<section id="archive-content" class="block-archive relative archive-{{ $randomNumber }}-custom-padding archive-{{ $randomNumber }}-custom-margin">
    @includeIf('components.archives.'.str_replace('.blade.php', '', $template), ['block' => $block])
</section>
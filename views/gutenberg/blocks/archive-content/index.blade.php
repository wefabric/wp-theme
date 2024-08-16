<?php

$randomNumber = rand(0, 1000);

$template = $block['data']['template'] ?? 'default';

?>
<section id="archive-content" class="block-tekst relative tekst-{{ $randomNumber }}-custom-padding tekst-{{ $randomNumber }}-custom-margin">
    @includeIf('components.archives.'.str_replace('.blade.php', '', $template), ['block' => $block])
</section>

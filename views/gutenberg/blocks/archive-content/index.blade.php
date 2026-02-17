<?php
    \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter;
    $template = $block['data']['template'] ?? 'default';
?>

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'archive-content' }}@endif" class="block-archive relative archive-{{ $randomNumber }}-custom-padding archive-{{ $randomNumber }}-custom-margin">
    @includeIf('components.archives.'.str_replace('.blade.php', '', $template), ['block' => $block])
</section>
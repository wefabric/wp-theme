<?php

add_filter('register_block_type_args', function (array $args, string $name): array {
    $blocks = [
        'trustindex/block-selector',
        'gravityforms/form',
        'wefabric/archive-render',
    ];

    if (in_array($name, $blocks, true)) {
        $args['api_version'] = 3;
    }

    return $args;
}, 10, 2);

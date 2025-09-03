<?php

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */

Route::any('api/indicator-items', function () {
    $result = [];
    foreach(get_post_types(['public' => true]) as $postType) {
        $result[$postType] = (int)wp_count_posts($postType)->publish;
    }
    return response()->json($result);
});

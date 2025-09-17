<?php

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */

Route::any('api/indicator-items', function () {
    $result = [];
    \Illuminate\Support\Facades\Cache::remember('post`-type, count', 60, function () {});
    foreach(get_post_types(['public' => true]) as $postType) {
        $result[$postType] = (int)wp_count_posts($postType)->publish;
    }
    return response()->json($result);
});

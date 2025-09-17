<?php

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */

Route::any('api/indicator-items', function () {
    $result = Cache::remember('post_type_counts', 60, function () {
        $data = [];

        foreach (get_post_types(['public' => true]) as $postType) {
            $data[$postType] = (int) wp_count_posts($postType)->publish;
        }

        return $data;
    });

    return response()->json($result);
});

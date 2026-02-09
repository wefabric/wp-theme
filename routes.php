<?php

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */

Route::any('api/indicator-items', function () {
    $cacheKey = 'api/indicator-items-v2';
    $result = Cache::remember($cacheKey, 60, function () {
        $data = [];

        foreach (get_post_types(['public' => true]) as $postType) {
            $counts = wp_count_posts($postType);
            $data[$postType] = (int) ($counts->publish ?? 0);
        }

        return $data;
    });

    return response()->json($result);
});

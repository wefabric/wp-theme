<?php
    $randomNumber = rand(0, 1000);
    $template = $block['data']['template'] ?? 'default';

    // Editor preview: the archive templates loop over the main query (@loop), which
    // is empty in the block editor. Show a few items of the post type this archive
    // page belongs to instead. Never runs on the frontend.
    $editorPreviewQuery = null;
    $originalWpQuery = null;
    $isEditorContext = is_admin() || (defined('REST_REQUEST') && REST_REQUEST);

    if ($isEditorContext && !have_posts()) {
        $archivePageId = (int) (get_the_ID() ?: ($_POST['post_id'] ?? $_GET['post'] ?? 0));
        $archivePostType = null;

        if ($archivePageId && $archivePageId === (int) get_option('page_for_posts')) {
            $archivePostType = 'post';
        } elseif ($archivePageId) {
            $archivePostType = array_search(
                $archivePageId,
                (new \Wefabric\WPSupport\Archive\Archive())->getArchivePostTypesArchivePageIds(),
                true
            ) ?: null;
        }

        if ($archivePostType) {
            global $wp_query;
            $originalWpQuery = $wp_query;
            $editorPreviewQuery = new \WP_Query([
                'post_type' => $archivePostType,
                'post_status' => 'publish',
                'posts_per_page' => 6,
            ]);
            $wp_query = $editorPreviewQuery;
        }
    }
?>

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'archive-content' }}@endif" class="block-archive relative archive-{{ $randomNumber }}-custom-padding archive-{{ $randomNumber }}-custom-margin">
    @includeIf('components.archives.'.str_replace('.blade.php', '', $template), ['block' => $block])
</section>

<?php
    if ($editorPreviewQuery) {
        global $wp_query;
        $wp_query = $originalWpQuery;
        wp_reset_postdata();
    }
?>

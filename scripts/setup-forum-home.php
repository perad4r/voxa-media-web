<?php

if (!function_exists('bbp_insert_forum')) {
    WP_CLI::error('bbPress must be active on the forum site before its initial structure is created.');
}

$forumId = get_current_blog_id();
$existingForums = get_posts([
    'post_type' => bbp_get_forum_post_type(),
    'post_status' => 'publish',
    'numberposts' => 1,
    'fields' => 'ids',
]);

if (!$existingForums) {
    $newForumId = bbp_insert_forum([
        'post_title' => 'Thảo luận chung',
        'post_content' => 'Không gian trao đổi câu hỏi, kinh nghiệm và ý tưởng cùng cộng đồng VOXA.',
        'post_status' => bbp_get_public_status_id(),
        'post_parent' => 0,
        'menu_order' => 0,
        'comment_status' => 'closed',
    ], ['status' => 'open']);

    if (is_wp_error($newForumId) || !$newForumId) {
        WP_CLI::error('Could not create the initial public discussion forum.');
    }
}

$page = get_page_by_path('forum', OBJECT, 'page');
if (!$page) {
    $pageId = wp_insert_post([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => 'Diễn đàn VOXA',
        'post_name' => 'forum',
        'post_content' => '[bbp-forum-index]',
    ], true);

    if (is_wp_error($pageId)) {
        WP_CLI::error('Could not create the forum landing page: ' . $pageId->get_error_message());
    }
} else {
    $pageId = (int) $page->ID;
}

update_blog_option($forumId, 'show_on_front', 'page');
update_blog_option($forumId, 'page_on_front', (int) $pageId);
WP_CLI::success('Forum landing page and discussion area are ready.');

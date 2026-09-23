<?php

$networkDomain = getenv('WP_NETWORK_DOMAIN');
$forumDomain = getenv('WP_FORUM_DOMAIN');
$scheme = getenv('WP_SCHEME') ?: 'https';
$port = getenv('WP_URL_PORT') ? ':' . getenv('WP_URL_PORT') : '';
$forumDomainWithPort = $forumDomain . $port;
$initialForumDomain = 'forum.' . $networkDomain . $port;
$sites = get_sites([
    'domain' => $forumDomainWithPort,
    'number' => 1,
]);

if (!$sites) {
    $sites = get_sites([
        'domain' => $initialForumDomain,
        'number' => 1,
    ]);
}

if (count($sites) !== 1) {
    WP_CLI::error('Could not find the forum subsite to map to ' . $forumDomainWithPort);
}

$forumId = (int) $sites[0]->blog_id;
if ($sites[0]->domain !== $forumDomainWithPort && !update_blog_details($forumId, ['domain' => $forumDomainWithPort, 'path' => '/'])) {
    WP_CLI::error('Could not map the forum subsite to ' . $forumDomainWithPort);
}

update_blog_option($forumId, 'home', $scheme . '://' . $forumDomainWithPort);
update_blog_option($forumId, 'siteurl', $scheme . '://' . $forumDomainWithPort);
update_blog_option($forumId, 'WPLANG', 'vi');

WP_CLI::success('Mapped forum site ' . $forumId . ' to ' . $forumDomainWithPort);

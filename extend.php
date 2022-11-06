<?php

namespace ClarkWinkelmann\MeilisearchDashboard;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(ForumAttributes::class),

    (new Extend\Middleware('forum'))
        ->insertBefore('flarum.forum.route_resolver', MeilisearchDashboardMiddleware::class),
];

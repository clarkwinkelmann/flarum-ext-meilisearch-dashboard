<?php

namespace ClarkWinkelmann\MeilisearchDashboard;

use Flarum\Api\Serializer\ForumSerializer;

class ForumAttributes
{
    public function __invoke(ForumSerializer $serializer): array
    {
        if ($serializer->getActor()->cannot('meilisearch-dashboard.access')) {
            return [];
        }

        return [
            'meilisearchDashboard' => true,
        ];
    }
}

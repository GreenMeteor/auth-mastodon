<?php

use humhub\modules\user\authclient\Collection;
use gm\humhub\modules\auth\mastodon\Module;
use gm\humhub\modules\auth\mastodon\Events;

return [
    'id' => 'auth-mastodon',
    'class' => Module::class,
    'namespace' => 'gm\humhub\modules\auth\mastodon',
    'events' => [
        [Collection::class, Collection::EVENT_AFTER_CLIENTS_SET, [Events::class, 'onAuthClientCollectionInit']]
    ],
];

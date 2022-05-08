<?php

namespace gm\humhub\modules\auth\mastodon;

use humhub\components\Event;
use humhub\modules\user\authclient\Collection;
use gm\humhub\modules\auth\mastodon\authclient\Mastodon;
use gm\humhub\modules\auth\mastodon\models\ConfigureForm;

class Events
{
    /**
     * @param Event $event
     */
    public static function onAuthClientCollectionInit($event)
    {
        /** @var Collection $authClientCollection */
        $authClientCollection = $event->sender;

        if (!empty(ConfigureForm::getInstance()->enabled)) {
            $authClientCollection->setClient('mastodon', [
                'class' => Mastodon::class,
                'clientId' => ConfigureForm::getInstance()->clientId,
                'clientSecret' => ConfigureForm::getInstance()->clientSecret,
                'apiBaseUrl' => ConfigureForm::getInstance()->serverUrl,
            ]);
        }
    }

}

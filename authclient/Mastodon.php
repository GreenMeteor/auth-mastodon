<?php

namespace gm\humhub\modules\auth\mastodon\authclient;

use Yii;
use yii\authclient\OAuth2;
use gm\humhub\modules\auth\mastodon\Module;
use gm\humhub\modules\auth\mastodon\models\ConfigureForm;

/**
 * Mastodon Authclient
 */
class Mastodon extends Oauth2
{

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
            'cssIcon' => 'fab fa-mastodon',
            'buttonBackgroundColor' => '#395697',
        ];
    }

    /**
     * @inheritdoc
     */
    public $authUrl;

    /**
     * @inheritdoc
     */
    public $tokenUrl;

    /**
     * @inheritdoc
     */
    public $apiBaseUrl;

    /**
     * @inheritdoc
     */
    public $revokeUrl;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $config = ConfigureForm::getInstance();

        $this->apiBaseUrl = $config->serverUrl . 'api/v1';
        $this->authUrl = $this->apiBaseUrl . 'oauth/authorize';
        $this->tokenUrl = $this->apiBaseUrl . 'oauth/token';
        $this->revokeUrl = $this->apiBaseUrl . 'oauth/revoke';

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public $scope = 'read';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->api('accounts/verify_credentials', 'GET');
    }

    /**
     * @inheritdoc
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $request->getHeaders()->set('Authorization', 'Bearer '. $accessToken->getToken());
    }

    /**
     * @inheritdoc
     */
    protected function defaultName() {
        return 'mastodon';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle() {
        return 'Mastodon';
    }
}
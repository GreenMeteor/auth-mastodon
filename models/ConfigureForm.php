<?php

namespace gm\humhub\modules\auth\mastodon\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use gm\humhub\modules\auth\mastodon\Module;

/**
 * The module configuration model
 */
class ConfigureForm extends Model
{
    /**
     * @var boolean Enable this authclient
     */
    public $enabled;

    /**
     * @var string the client id provided by Mastodon site
     */
    public $clientId;

    /**
     * @var string the client secret provided by Mastodon site
     */
    public $clientSecret;

    /**
     * @var string readonly
     */
    public $redirectUri;

    /**
     * @var string
     */
    public $serverUrl;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId', 'clientSecret', 'serverUrl'], 'required'],
            [['clientId', 'clientSecret', 'serverUrl'], 'string'],
            [['enabled'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enabled' => Yii::t('AuthMastodonModule.base', 'Enabled'),
            'clientId' => Yii::t('AuthMastodonModule.base', 'Client ID'),
            'clientSecret' => Yii::t('AuthMastodonModule.base', 'Client secret'),
            'serverUrl' => Yii::t('AuthMastodonModule.base', 'Mastodon Server Url'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
        ];
    }

    /**
     * Loads the current module settings
     */
    public function loadSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('auth-mastodon');

        $settings = $module->settings;

        $this->enabled = (boolean)$settings->get('enabled');
        $this->clientId = $settings->get('clientId');
        $this->clientSecret = $settings->get('clientSecret');
        $this->serverUrl = $settings->get('serverUrl');

        $this->redirectUri = Url::to(['/user/auth/external', 'authclient' => 'mastodon'], true);
    }

    /**
     * Saves module settings
     */
    public function saveSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('auth-mastodon');

        $module->settings->set('enabled', (boolean)$this->enabled);
        $module->settings->set('clientId', $this->clientId);
        $module->settings->set('clientSecret', $this->clientSecret);
        $module->settings->set('serverUrl', $this->serverUrl);

        return true;
    }

    /**
     * Returns a loaded instance of this configuration model
     */
    public static function getInstance()
    {
        $config = new static;
        $config->loadSettings();

        return $config;
    }

}

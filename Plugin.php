<?php

namespace Kanboard\Plugin\RedisCache;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Decorator\MetadataCacheDecorator;
use Kanboard\Core\Cache\BaseCache;
use Kanboard\Core\Tool;
use LogicException;

defined('REDIS_ADDRESS') or define('REDIS_ADDRESS', '');
defined('REDIS_PORT') or define('REDIS_PORT', null);
defined('REDIS_USERNAME') or define('REDIS_USERNAME', '');
defined('REDIS_PASSWORD') or define('REDIS_PASSWORD', '');
defined('REDIS_DATABASE') or define('REDIS_DATABASE', null);
defined('REDIS_PREFIX') or define('REDIS_PREFIX', '');

class Plugin extends Base
{
    public function initialize()
    {

        // $this->container['cacheDriver'] = function () {
        //     return new RedisCache(
        //         $this->getRedisAddress(),
        //         $this->getRedisPort(),
        //         $this->getRedisUsername(),
        //         $this->getRedisPassword(),
        //         $this->getRedisDatabase(),
        //         $this->getRedisPrefix()
        //     );
        // };

        $this->template->hook->attach('template:config:integrations', 'RedisCache:config');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getPluginName()
    {
        return 'Redis Cache';
    }

    public function getPluginDescription()
    {
        return t('This plugin allow to use Redis as a cache');
    }

    public function getPluginAuthor()
    {
        return 'Giacomo Rossetto';
    }

    public function getPluginVersion()
    {
        return '0.1.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-redis-cache';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.37';
    }

    public function isConfigured()
    {
        if (!$this->getRedisAddress() || !$this->getRedisPort() || !$this->getRedisUsername() || !$this->getRedisPassword()) {
            $this->logger->info('Plugin Redis Cache not configured!');
            return false;
        }

        return true;
    }

    public function getRedisAddress()
    {
        if (REDIS_ADDRESS) {
            return REDIS_ADDRESS;
        }

        return $this->configModel->get('redis_address');
    }

    public function getRedisPort()
    {
        if (REDIS_PORT) {
            return REDIS_PORT;
        }

        return $this->configModel->get('redis_port');
    }

    public function getRedisUsername()
    {
        if (REDIS_USERNAME) {
            return REDIS_USERNAME;
        }

        return $this->configModel->get('redis_username');
    }

    public function getRedisPassword()
    {
        if (REDIS_PASSWORD) {
            return REDIS_PASSWORD;
        }

        return $this->configModel->get('redis_password');
    }

    public function getRedisDatabase()
    {
        if (REDIS_DATABASE) {
            return REDIS_DATABASE;
        }

        return $this->configModel->get('redis_database');
    }

    public function getRedisPrefix()
    {
        if (REDIS_PREFIX) {
            return REDIS_PREFIX;
        }

        return $this->configModel->get('redis_prefix');
    }
}

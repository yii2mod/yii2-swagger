<?php

namespace yii2mod\swagger;

use Swagger\Annotations\Swagger;
use Yii;
use yii\base\Action;
use yii\caching\Cache;
use yii\di\Instance;
use yii\web\Response;

/**
 * Class OpenAPIRenderer is responsible for generating the JSON spec.
 *
 * @package yii2mod\swagger\actions
 */
class OpenAPIRenderer extends Action
{
    /**
     * @var string|array|\Symfony\Component\Finder\Finder The directory(s) or filename(s).
     * If you configured the directory must be full path of the directory.
     */
    public $scanDir;

    /**
     * @var array the options passed to `Swagger`, Please refer the `Swagger\scan` function for more information
     */
    public $scanOptions = [];

    /**
     * @var Cache|array|string the cache used to improve generating api documentation performance. This can be one of the followings:
     *
     * - an application component ID (e.g. `cache`)
     * - a configuration array
     * - a [[yii\caching\Cache]] object
     *
     * When this is not set, it means caching is not enabled
     */
    public $cache = 'cache';

    /**
     * @var int default duration in seconds before the cache will expire
     */
    public $cacheDuration = 360;

    /**
     * @var string the key used to store swagger data in cache
     */
    public $cacheKey = 'api-swagger-cache';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        if ($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, Cache::class);
        }
    }

    /**
     * @inheritdoc
     */
    public function run(): Response
    {
        $this->enableCORS();

        return $this->controller->asJson($this->getSwaggerDocumentation());
    }

    /**
     * Scan the filesystem for swagger annotations and build swagger-documentation.
     *
     * @return Swagger
     */
    protected function getSwaggerDocumentation(): Swagger
    {
        if (!$this->cache instanceof Cache) {
            return \Swagger\scan($this->scanDir, $this->scanOptions);
        }

        return $this->cache->getOrSet($this->cacheKey, function () {
            return \Swagger\scan($this->scanDir, $this->scanOptions);
        }, $this->cacheDuration);
    }

    /**
     * Enable CORS
     */
    protected function enableCORS(): void
    {
        $headers = Yii::$app->getResponse()->getHeaders();

        $headers->set('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT');
        $headers->set('Access-Control-Allow-Origin', '*');
    }
}

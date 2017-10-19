<?php

namespace yii2mod\swagger\tests\actions;

use Swagger\Annotations\Info;
use Swagger\Annotations\Path;
use Yii;
use yii\web\Response;
use yii2mod\swagger\OpenAPIRenderer;
use yii2mod\swagger\tests\TestCase;

class OpenAPIRendererTest extends TestCase
{
    public function testCheckApiInfo()
    {
        $response = $this->runAction([
            'scanDir' => [
                Yii::getAlias('@yii2mod/tests/unit/swagger/data'),
            ],
        ]);

        $this->assertInstanceOf(Info::class, $response->data->info);
        $this->assertEquals('Simple API', $response->data->info->title);
        $this->assertEquals('1.0', $response->data->info->version);
    }

    public function testCheckPaths()
    {
        $response = $this->runAction([
            'scanDir' => [
                Yii::getAlias('@yii2mod/tests/unit/swagger/data'),
            ],
        ]);

        $path = $response->data->paths[0];

        $this->assertInstanceOf(Path::class, $path);
        $this->assertEquals('Retrieves the collection of User resources.', $path->get->summary);
        $this->assertEquals('/user', $path->get->path);
    }

    public function testDisableCache()
    {
        $response = $this->runAction([
            'scanDir' => [
                Yii::getAlias('@yii2mod/tests/unit/swagger/data'),
            ],
            'cache' => null,
        ]);

        $this->assertInstanceOf(Info::class, $response->data->info);
    }

    /**
     * Runs the action.
     *
     * @param array $config
     *
     * @return Response
     */
    protected function runAction(array $config = []): Response
    {
        $action = new OpenAPIRenderer('json-schema', $this->createController(), $config);

        return $action->run();
    }
}

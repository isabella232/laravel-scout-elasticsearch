<?php
declare(strict_types=1);

namespace Tests;

use Elasticsearch\Client;

/**
 * Class IntegrationTestCase.
 */
class IntegrationTestCase extends TestCase
{
    /**
     * @var Client
     */
    protected $elasticsearch;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->elasticsearch = $this->app->make(Client::class);

        $this->elasticsearch->indices()->delete(['index' => '_all']);

//        \DB::listen(function($sql) {
//            var_dump($sql->sql);
//        });
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('elasticsearch', require(__DIR__.'/../config/elasticsearch.php'));
        $app['config']->set('elasticsearch.indices.mappings.products', [
            'properties' => [
                'type' => [
                    'type' => 'keyword',
                ],
                'price' => [
                    'type' => 'integer',
                ],
            ],
        ]);
    }
}

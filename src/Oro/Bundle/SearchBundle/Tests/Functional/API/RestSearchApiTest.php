<?php

namespace Oro\Bundle\SearchBundle\Tests\Functional\API;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Oro\Bundle\TestFrameworkBundle\Test\ToolsAPI;
use Oro\Bundle\TestFrameworkBundle\Test\Client;

/**
 * @outputBuffering enabled
 * @db_isolation
 * @db_reindex
 */
class RestSearchApiTest extends WebTestCase
{
    protected static $hasLoaded = false;
    /** @var client */
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient(array(), ToolsAPI::generateWsseHeader());
        if (!self::$hasLoaded) {
            $this->client->appendFixtures(__DIR__ . DIRECTORY_SEPARATOR . 'DataFixtures');
        }
        self::$hasLoaded = true;
    }

    /**
     * @param array $request
     * @param array $response
     *
     * @dataProvider requestsApi
     */
    public function testApi($request, $response)
    {
        foreach ($request as $key => $value) {
            if (is_null($value)) {
                unset($request[$key]);
            }
        }

        $this->client->request(
            'GET',
            $this->client->generate('oro_api_get_search'),
            $request,
            array(),
            ToolsAPI::generateWsseHeader()
        );

        $result = $this->client->getResponse();

        ToolsAPI::assertJsonResponse($result, 200);
        $result = json_decode($result->getContent(), true);
        //compare result
        $this->assertEqualsResponse($response, $result);
    }

    /**
     * Test API response
     *
     * @param array $response
     * @param array $result
     */
    protected function assertEqualsResponse($response, $result)
    {
        $this->assertEquals($response['records_count'], $result['records_count']);
        $this->assertEquals($response['count'], $result['count']);
        if (isset($response['rest']['data']) && is_array($response['rest']['data'])) {
            foreach ($response['rest']['data'] as $key => $object) {
                foreach ($object as $property => $value) {
                    $this->assertEquals($value, $result['data'][$key][$property]);
                }
            }
        }
    }

    /**
     * Data provider for REST API tests
     *
     * @return array
     */
    public function requestsApi()
    {
        return ToolsAPI::requestsApi(__DIR__ . DIRECTORY_SEPARATOR . 'requests');
    }
}

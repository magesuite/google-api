<?php

namespace MageSuite\GoogleApi\Test\Unit\Service;


class GeoLocationResolverTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \MageSuite\GoogleApi\Service\GeoLocationResolver
     */
    protected $geoLocationResolver;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->geoLocationResolver = $this->objectManager->get(\MageSuite\GoogleApi\Service\GeoLocationResolver::class);
    }

    public static function parametersDataProvider()
    {
        return [
            [
                ['key' => 'testkey', 'address' => 'Street 1', 'language' => 'DE', 'region' => 'DE', 'components' => 'dummy'],
                ['key' => 'testkey', 'address' => 'Street 1', 'language' => 'DE', 'region' => 'DE', 'components' => 'dummy']
            ],
            [
                ['key' => 'testkey', 'address' => 'Street 1', 'language' => 'DE', 'region' => 'DE', 'components' => 'dummy', 'form_key' => 'xyz'],
                ['key' => 'testkey', 'address' => 'Street 1', 'language' => 'DE', 'region' => 'DE', 'components' => 'dummy']
            ],
            [
                ['key' => 'testkey', 'address' => 'Street 1', 'language' => 'DE', 'components' => null],
                ['key' => 'testkey', 'address' => 'Street 1', 'language' => 'DE', 'region' => 'US', 'components' => null]
            ]
        ];
    }

    /**
     * @dataProvider parametersDataProvider
     * @param $params
     * @param $expected
     */
    public function testItReturnsCorrectParameters($params, $expected)
    {
        $this->assertEquals($expected, $this->geoLocationResolver->prepareParameters($params));
    }
}

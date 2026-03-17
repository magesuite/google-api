<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Test\Unit\Service;

class GeoLocationResolverTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\GoogleApi\Service\GeoLocationResolver $geoLocationResolver;

    public function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->geoLocationResolver = $objectManager->get(\MageSuite\GoogleApi\Service\GeoLocationResolver::class);
    }

    /**
     * @dataProvider parametersDataProvider
     */
    public function testItReturnsCorrectParameters(array $params, array $expected): void
    {
        $this->assertEquals($expected, $this->geoLocationResolver->prepareParameters($params));
    }

    public static function parametersDataProvider(): array
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
}

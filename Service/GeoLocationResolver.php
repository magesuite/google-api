<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Service;

class GeoLocationResolver extends AbstractGoogleApiResolver
{
    protected const API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';
    protected const ALLOWED_PARAMETERS = ['key', 'address', 'language', 'region', 'components'];

    protected function getApiUrl(): string
    {
        return self::API_URL;
    }

    protected function getAllowedParameters(): array
    {
        return self::ALLOWED_PARAMETERS;
    }
}
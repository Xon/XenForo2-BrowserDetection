<?php

namespace SV\BrowserDetection;

use SV\BrowserDetection\MobileDetect\MobileDetect;

abstract class Listener
{
    private function __construct() {}

    /** @noinspection PhpUnusedParameterInspection */
    public static function templaterGlobalData(\XF\App $app, array &$data, $reply): void
    {
        $data['mobileDetect'] = self::getMobileDetection();
    }

    /** @var array<string, MobileDetectCache> */
    protected static $mobileDetect = [];

    public static function getUserAgent(): string
    {
        $request = \XF::app()->request();
        if ($request === null)
        {
            return '';
        }

        return (string)$request->getUserAgent();
    }

    /**
     * @param string|null   $userAgent
     * @return null|MobileDetectCache
     * @throws \Exception
     */
    public static function getMobileDetection(?string $userAgent = null): ?MobileDetectCache
    {
        if ($userAgent === null)
        {
            $userAgent = self::getUserAgent();
        }

        $userAgent = (string)$userAgent;

        $mobileDetect = self::$mobileDetect[$userAgent] ?? null;
        if ($mobileDetect === null)
        {
            $app = \XF::app();

            $mobileDetectClass = $app->extendClass(MobileDetect::class);
            $mobileDetectCacheClass = $app->extendClass(MobileDetectCache::class);

            self::$mobileDetect[$userAgent] = $mobileDetect = new $mobileDetectCacheClass($mobileDetectClass);
        }

        return $mobileDetect;
    }
}
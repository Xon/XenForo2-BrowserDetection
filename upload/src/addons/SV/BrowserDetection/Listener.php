<?php

namespace SV\BrowserDetection;


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
        $app = \XF::app();
        $request = $app->request();
        if (!$request)
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

        if (!$userAgent)
        {
            return null;
        }

        $mobileDetect = &self::$mobileDetect;
        if (!isset($mobileDetect[$userAgent]))
        {
            $app = \XF::app();

            $mobileDetectClass = $app->extendClass('SV\BrowserDetection\MobileDetect');
            $mobileDetectCacheClass = $app->extendClass('SV\BrowserDetection\MobileDetectCache');

            $mobileDetect[$userAgent] = new $mobileDetectCacheClass($mobileDetectClass, $userAgent);
        }

        return $mobileDetect[$userAgent];
    }
}
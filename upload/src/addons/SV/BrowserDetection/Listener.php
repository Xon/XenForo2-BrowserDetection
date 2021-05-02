<?php

namespace SV\BrowserDetection;


class Listener
{
    /** @noinspection PhpUnusedParameterInspection */
    public static function templaterGlobalData(\XF\App $app, array &$data, $reply)
    {
        $data['mobileDetect'] = self::getMobileDetection();
    }

    static $mobileDetect = [];

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
    public static function getMobileDetection(string $userAgent = null)
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
<?php

namespace SV\BrowserDetection;


class Listener
{
    public static function templaterGlobalData(/** @noinspection PhpUnusedParameterInspection */ \XF\App $app, array &$data, $reply)
    {
        $data['mobileDetect'] = self::getMobileDetection();
    }

    static $mobileDetect = [];

    public static function getUserAgent()
    {
        $app = \XF::app();
        $request = $app->request();
        if (!$request)
        {
            return null;
        }

        return $request->getUserAgent();
    }

    /**
     * @param string|null   $userAgent
     * @return null|MobileDetectCache
     * @throws \Exception
     */
    public static function getMobileDetection($userAgent = null)
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
        if (isset($mobileDetect[$userAgent]))
        {
            $app = \XF::app();

            $mobileDetectClass = $app->extendClass('SV\BrowserDetection\MobileDetect');
            $mobileDetectCacheClass = $app->extendClass('SV\BrowserDetection\MobileDetectCache');

            $mobileDetect[$userAgent] = new $mobileDetectCacheClass($mobileDetectClass, $userAgent);
        }

        return $mobileDetect[$userAgent];
    }
}
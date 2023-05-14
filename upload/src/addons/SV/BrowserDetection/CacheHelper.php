<?php

namespace SV\BrowserDetection;

abstract class CacheHelper
{
    private function __construct() {}

    public static function getPageCacheId(\XF\Http\Request $request): string
    {
        $options = \XF::options();

        $styleId = \intval($request->getCookie('style_id', 0));
        if (!$styleId)
        {
            $styleId = $options->defaultStyleId;
        }
        $languageId = \intval($request->getCookie('language_id', 0));
        if (!$languageId)
        {
            $languageId = $options->defaultLanguageId;
        }

        $uri = $request->getFullRequestUri();
        /** @noinspection RegExpSingleCharAlternation */
        $uri = \preg_replace('#(\?|&)_debug=[^&]*#', '', $uri);

        $mobileDetect = Listener::getMobileDetection();
        $isMobile = $mobileDetect && $mobileDetect->isMobile() ? "_m1" : "_m0";

        return 'page_' . \sha1($uri) . '_' . \strlen($uri) . "_s{$styleId}_l{$languageId}_v" . \XF\PageCache::CACHE_VERSION . $isMobile;
    }
}
# Browser Detection

A light-weight shim around [Mobile_detect](https://github.com/serbanghita/Mobile-Detect) for XenForo 2


## XF2.1 Page caching

The integration mobile detection with XF2.1+ full-page caching, add to the config.php this;
```php
$config['pageCache']['onSetup'] = function (\XF\PageCache $pageCache) {
    $pageCache->setCacheIdGenerator(function(\XF\Http\Request $request) {
        return \SV\BrowserDetection\CacheHelper::getPageCacheId($request);
    });
};
```

## licence

Add-on licence file: LICENSE.md
Mobile-Detect licence file: MobileDetectLicense.md

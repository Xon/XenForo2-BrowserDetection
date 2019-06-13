# Browser Detection

A light-weight shim around [Mobile_detect](https://github.com/serbanghita/Mobile-Detect) for XenForo 2

## Usage

The add-on injects the global variable `$mobileDetect`, check that the variable is set before calling any methods to prevent errors during upgrades or if the add-on is disabled.

```
<xf:if is="$mobileDetect && $mobileDetect.isMobile()">
    Is Mobile
<xf:else />
    Not Mobile
</xf:if>
```

```
<xf:if is="$mobileDetect && $mobileDetect.is('Firefox')">
    Is Firefox
<xf:else />
    Not Firefox
</xf:if>
```

```
<xf:if is="$mobileDetect && $mobileDetect.is('Chrome')">
    Is Chrome
<xf:else />
    Not Chrome
</xf:if>
```

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

<?php

namespace SV\BrowserDetection;

class TemplateCallback
{
    public static function getPageContainerCss($mobileDetect): string
    {
        $output = '';
        $addOns = \XF::app()->container('addon.cache');

        if ($mobileDetect &&
            isset($addOns['SV/BrowserDetection']) &&
            $mobileDetect instanceof MobileDetectCache)
        {
            if ($mobileDetect->isMobile())
            {
                $output .= 'is-mobile ';
            }
            if ($mobileDetect->isTablet())
            {
                $output .= 'is-tablet ';
            }
        }

        return $output;
    }
}
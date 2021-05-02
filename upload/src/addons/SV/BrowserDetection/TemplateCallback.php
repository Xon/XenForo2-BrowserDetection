<?php

namespace SV\BrowserDetection;

class TemplateCallback
{
    /** @noinspection PhpUnusedParameterInspection */
    public static function getPageContainerCss(string $contents, array $params, \XF\Template\Templater $templater): string
    {
        $output = '';
        $addOns = \XF::app()->container('addon.cache');

        $mobileDetect = $params[0] ?? null;
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
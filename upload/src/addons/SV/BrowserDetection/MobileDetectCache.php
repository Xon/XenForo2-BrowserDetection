<?php

namespace SV\BrowserDetection;

class MobileDetectCache
{
    /** @var MobileDetect */
    protected $mobileDetect;
    /** @var array */
    protected $cache = [];
    /** @var string */
    protected $mobileDetectClass;
    /** @var string */
    protected $userAgent;

    public function __construct(string $mobileDetectClass, string $userAgent)
    {
        $this->mobileDetectClass = $mobileDetectClass;
        $this->userAgent = $userAgent;
    }

    public function getMobileDetect(): MobileDetect
    {
        if ($this->mobileDetect === null)
        {
            $class = $this->mobileDetectClass;
            $this->mobileDetect = new $class(null, $this->userAgent);
        }

        return $this->mobileDetect;
    }

    public function getHtmlCss(): string
    {
        $output = '';

        if ($this->isMobile())
        {
            $output .= ' is-mobile ';
        }
        if ($this->isTablet())
        {
            $output .= ' is-tablet ';
        }

        return $output;
    }

    public function isMobile(): bool
    {
        if (!isset($this->cache['isMobile']))
        {
            $this->cache['isMobile'] = $this->getMobileDetect()->isMobile();
        }

        return $this->cache['isMobile'];
    }

    public function isTablet(): bool
    {
        if (!isset($this->cache['isTablet']))
        {
            $this->cache['isTablet'] = $this->getMobileDetect()->isTablet();
        }

        return $this->cache['isTablet'];
    }

    public function is(string $key): bool
    {
        if (!isset($this->cache['is'][$key]))
        {
            $this->cache['is'][$key] = $this->getMobileDetect()->is($key);
        }

        return $this->cache['is'][$key];
    }

    public function mobileGrade(): string
    {
        if (!isset($this->cache['mobileGrade']))
        {
            $this->cache['mobileGrade'] = $this->getMobileDetect()->mobileGrade();
        }

        return $this->cache['mobileGrade'];
    }
}
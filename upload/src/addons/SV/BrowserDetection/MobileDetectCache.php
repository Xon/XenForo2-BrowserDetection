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

    /**
     * MobileDetectCache constructor.
     *
     * @param string $mobileDetectClass
     * @param string $userAgent
     */
    public function __construct($mobileDetectClass, $userAgent)
    {
        $this->mobileDetectClass = $mobileDetectClass;
        $this->userAgent = $userAgent;
    }

    /**
     * @return MobileDetect
     */
    public function getMobileDetect()
    {
        if ($this->mobileDetect === null)
        {
            $class = $this->mobileDetectClass;
            $this->mobileDetect = new $class(null, $this->userAgent);
        }

        return $this->mobileDetect;
    }

    /**
     * @return bool
     */
    public function isMobile()
    {
        if (!isset($this->cache['isMobile']))
        {
            $this->cache['isMobile'] = $this->getMobileDetect()->isMobile();
        }

        return $this->cache['isMobile'];
    }

    /**
     * @return bool
     */
    public function isTablet()
    {
        if (!isset($this->cache['isTablet']))
        {
            $this->cache['isTablet'] = $this->getMobileDetect()->isTablet();
        }

        return $this->cache['isTablet'];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function is($key)
    {
        if (!isset($this->cache['is'][$key]))
        {
            $this->cache['is'][$key] = $this->getMobileDetect()->is($key);
        }

        return $this->cache['is'][$key];
    }

    /**
     * @return string
     */
    public function mobileGrade()
    {
        if (!isset($this->cache['mobileGrade']))
        {
            $this->cache['mobileGrade'] = $this->getMobileDetect()->mobileGrade();
        }

        return $this->cache['mobileGrade'];
    }
}
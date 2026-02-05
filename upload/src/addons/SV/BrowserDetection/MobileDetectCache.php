<?php

namespace SV\BrowserDetection;

use function call_user_func_array;
use function is_callable;

class MobileDetectCache
{
    /** @var MobileDetect */
    protected $mobileDetect;
    /** @var array */
    protected $cache = [];
    /** @var string */
    protected $mobileDetectClass;

    public function __construct(string $mobileDetectClass)
    {
        $this->mobileDetectClass = $mobileDetectClass;
    }

    public function getMobileDetect(): MobileDetect
    {
        if ($this->mobileDetect === null)
        {
            $class = $this->mobileDetectClass;
            $this->mobileDetect = new $class();
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
        $result = $this->cache['isMobile'] ?? null;
        if ($result === null)
        {
            $this->cache['isMobile'] = $result = $this->getMobileDetect()->isMobile();
        }

        return $result;
    }

    public function isTablet(): bool
    {
        $result = $this->cache['isTablet'] ?? null;
        if ($result === null)
        {
            $this->cache['isTablet'] = $result = $this->getMobileDetect()->isTablet();
        }

        return $result;
    }

    public function is(string $key): bool
    {
        $result = $this->cache['is'][$key] ?? null;
        if ($result === null)
        {
            $this->cache['is'][$key] = $result = $this->getMobileDetect()->is($key);
        }

        return $result;
    }

    public function match(string $regex, ?string $userAgent = null): bool
    {
        if ($userAgent === null || $userAgent === '')
        {
            return false;
        }

        $key = 'match.' . $regex . '.' . $userAgent;
        $result = $this->cache[$key] ?? null;
        if ($result === null)
        {
            $this->cache[$key] = $result = $this->getMobileDetect()->match($regex, $userAgent);
        }

        return $result;
    }

    public function __call($method, $args)
    {
        $mobileDetect = $this->getMobileDetect();
        $callable = [$mobileDetect, $method];

        if (!is_callable($callable))
        {
            throw new \BadMethodCallException('Method '.$method.' is not callable on Mobile_Detect');
        }

        return call_user_func_array($callable, $args);
    }
}
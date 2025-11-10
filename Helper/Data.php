<?php

namespace Consentmanager\Cmp\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    public function getStoreConfig(string $path): string
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE) ?? '';
    }

    public function isEnabled(): bool
    {
        return (bool) $this->getStoreConfig('cmp/settings/active');
    }

    public function getCMPId(): string
    {
        return $this->getStoreConfig('cmp/settings/cmp_id');
    }

    public function getBlockingMode(): string
    {
        return $this->getStoreConfig('cmp/settings/blocking_mode');
    }

    public function getCustomHtml(): string
    {
        return $this->getStoreConfig('cmp/settings/custom_html');
    }

    public function getCdn(): string
    {
        return $this->getStoreConfig('cmp/settings/cdn');
    }

    public function getHost(): string
    {
        return $this->getStoreConfig('cmp/settings/host');
    }
}

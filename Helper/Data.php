<?php
namespace Consentmanager\Cmp\Helper;

use Consentmanager\Cmp\Api\Data as CMPData;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public $resource = '';
    protected $configWriter;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
    ) {
        parent::__construct($context);
        $this->resource = $resource;
        $this->configWriter = $configWriter;
    }
    
    public function getStoreConfig($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function setData($path, $value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0)
    {
        $this->configWriter->save($path, $value, $scope, $scopeId);
    }
    
    public function isEnabled()
    {
        return $this->getStoreConfig(CMPData::CONFIG_ACTIVE_PATH);
    }
    
    public function getCMPId()
    {
        return $this->getStoreConfig(CMPData::CONFIG_ID_PATH);
    }
	
    public function getBlockingMode()
    {
        return $this->getStoreConfig(CMPData::CONFIG_BLOCKING_PATH);
    }
    
    public function getCdn()
    {
        return $this->getStoreConfig(CMPData::CONFIG_CDN_PATH);
    }
    
    public function getHost()
    {
        return $this->getStoreConfig(CMPData::CONFIG_HOST_PATH);
    }

    public function getCustomHtml()
    {
        return '';
    }
}

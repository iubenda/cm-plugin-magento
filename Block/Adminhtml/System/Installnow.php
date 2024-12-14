<?php

namespace Consentmanager\Cmp\Block\Adminhtml\System;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Consentmanager\Cmp\Api\Data as CMPData;

class Installnow extends \Magento\Config\Block\System\Config\Form\Field
{

    protected $_template = 'Consentmanager_Cmp::installnow.phtml';

    protected $helper;

    protected $locale;

    protected $storeManager;

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        \Consentmanager\Cmp\Helper\Data $helper,
        \Magento\Framework\Locale\Resolver $locale,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Context $context,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->locale = $locale;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve Element HTML fragment
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    public function getDomain()
    {
        $url = $this->storeManager->getStore()->getBaseUrl();
        return $url;
    }

    public function getLang()
    {
        $haystack  = $this->locale->getLocale(); 
        $lang = strstr($haystack, '_', true);
        return $lang;
    }

    public function getInstallUrl()
    {
        return CMPData::INSTALL_URL;
    }

    public function getType()
    {
        return CMPData::TYPE;
    }

    public function getSource()
    {
        return CMPData::SOURCE;
    }

    public function getSaveUrl()
    {
        return $this->getUrl('cmp/system/save');
    }
}

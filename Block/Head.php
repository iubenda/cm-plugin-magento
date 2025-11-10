<?php

namespace Consentmanager\Cmp\Block;

use Consentmanager\Cmp\Helper\Data as Helper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Head extends Template
{
    private Helper $helper;

    public function __construct(
        Helper $helper,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->helper = $helper;
    }

    public function getHelper(): Helper
    {
        return $this->helper;
    }
}

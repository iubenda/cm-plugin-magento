<?php

namespace Consentmanager\Cmp\Controller\Adminhtml\System;

use Magento\Backend\App\Action;
use Consentmanager\Cmp\Api\Data as CMPData;
use Magento\Store\Model\ScopeInterface as StoreScopeInterface;
use Magento\Framework\App\ScopeInterface;

class Save extends Action
{
    protected $helper;
    protected $cacheTypeList;

    public function __construct(
        \Consentmanager\Cmp\Helper\Data $helper,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        Action\Context $context
    ) {
        $this->helper = $helper;
        $this->cacheTypeList = $cacheTypeList;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = array();

        try {
            $params = $this->getRequest()->getParams();
            if (isset($params['credentials'])) {
                $credentials = $params['credentials'];
                $credentialsData = json_decode($credentials, true);

                $website = (int)$params['website'];
                $store = (int)$params['store'];

                $scope = ScopeInterface::SCOPE_DEFAULT;
                $scopeId = 0;

                if ($store > 0) {
                    $scope = StoreScopeInterface::SCOPE_STORES;
                    $scopeId = $store;
                } else if ($website > 0) {
                    $scope = StoreScopeInterface::SCOPE_WEBSITES ;
                    $scopeId = $website;
                }

                $this->helper->setData(CMPData::CONFIG_ACTIVE_PATH, 1);
                $this->helper->setData(CMPData::CONFIG_ID_PATH, $this->sanitizeText($credentialsData['codeid']), $scope, $scopeId);
                $this->helper->setData(CMPData::CONFIG_BLOCKING_PATH, $this->sanitizeText($credentialsData['blocking']), $scope, $scopeId);
                $this->helper->setData(CMPData::CONFIG_HOST_PATH, $this->sanitizeText($credentialsData['host']), $scope, $scopeId);
                $this->helper->setData(CMPData::CONFIG_CDN_PATH, $this->sanitizeText($credentialsData['cdn']), $scope, $scopeId);

                $this->cacheTypeList->cleanType(\Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER);
                //$this->cacheTypeList->cleanType(\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER);

                $message = __('Installation successful. ');
                $message .= '<br/>'.__('Please clear the Magento Cache once at here: System => Cache Management => Flush Magento Cache.');
                $response['status'] = 'success';
                $response['message'] = $message;

            } else {
                throw new \Exception(__('Credentials not fetched.'));
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $message = __('Installation failed. ').$errorMessage;
            $response['status'] = 'error';
            $response['message'] = $message;
        }

        echo json_encode($response);

        exit;
    }

    private function sanitizeText($value) 
    {
        $value = strip_tags($value);
        $value = trim($value);
        return $value;
    }

    protected function _isAllowed()
    {
        return true;
    }
}
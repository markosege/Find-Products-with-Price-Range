<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace George\ProductsRange\Controller\Search;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * @var Session
     */
    protected $customerSession;

    public function __construct(
        Context $context,
        Session $customerSession,
        ResultFactory $resultFactory
    ) {
        $this->resultFactory    =   $resultFactory;
        $this->customerSession  =   $customerSession;
    }
    /**
     * "Products in Range" search grid page
     *
     */
    public function execute()
    {
        if (!$this->customerSession->isLoggedIn()) {
            $resultRedirect =  $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setUrl('/customer/account/login');
        }
        $resultPage =  $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend((__('Find Products with Price Range')));
        return $resultPage;
    }
}
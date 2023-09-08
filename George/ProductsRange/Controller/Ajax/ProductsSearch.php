<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace George\ProductsRange\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use George\ProductsRange\Model\ProductData;

class ProductsSearch implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ProductData
     */
    protected $helper;

    /**
     * @var float
     */
    protected $minPrice;

    /**
     * @var float
     */
    protected $maxPrice;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ProductData $helper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ProductData $helper,
        RequestInterface $request
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * "Products Range" load grid results
     *
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        if (!$this->validateFormData()) {
            return $resultJson->setData([
                'error' => 'Please enter the correct value and try again.'
            ]);
        }
        return $resultJson->setData($this->getProductData());
    }

    /**
     * Validate form values
     *
     * @return boolean
     */
    protected function validateFormData()
    {
        if (!$this->request->getParam('min_price') ||
            !$this->request->getParam('max_price')) {
            return false;
        }
        $this->minPrice = (float) $this->request->getParam('min_price');
        $this->maxPrice = (float) $this->request->getParam('max_price');
        if ($this->maxPrice < $this->minPrice) {
            return false;
        }
        if ($this->maxPrice > ($this->minPrice * 5)) {
            return false;
        }
        return true;
    }

    /**
     * Get product data for grid
     *
     * @return array
     */
    protected function getProductData()
    {
        return $this->helper->setPriceRange([
            'min_price' => $this->minPrice,
            'max_price' => $this->maxPrice
        ])->setSortBy(
            $this->request->getParam('sort_by')
        )->getProductCollection();
    }

}
<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace George\ProductsRange\Block\Search;

use Magento\Framework\View\Element\Template;
class Index extends Template
{
    /**
     * @return Index
     */
    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Find Products with Price Range'));
        return parent::_prepareLayout();
    }
    /**
     * Get form submission URL
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('productsrange/ajax/productssearch');
    }
}
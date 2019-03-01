<?php

namespace Shopstack\BestSellerCartRule\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Zend_Db_Select;

class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    protected $bestSellerList;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get list ID products sort by qty ordered
     *
     * @return array
     */
    public function getBestSellerData()
    {
        if ($this->bestSellerList == null) {
            $collection = $this->collectionFactory->create()
                ->addStoreFilter($this->getStoreId())
                ->setPeriod('day');

            $collection->getSelect()
                ->reset(Zend_Db_Select::GROUP)
                ->reset(Zend_Db_Select::ORDER)
                ->group('product_id')
                ->order('qty_ordered DESC');
            $this->bestSellerList = $collection->load()->getColumnValues('product_id');
        }

        return $this->bestSellerList;
    }

    /**
     * Get Position of product in best seller list by id
     *
     * @param $productId
     * @return false|int|string
     */
    public function getPositionInBestSeller($productId)
    {
        $pos = array_search($productId, $this->getBestSellerData());
        if ($pos !== false) {
            $pos++;
        } else {
            $pos = count($this->getBestSellerData()) + 1;
        }
        return $pos;
    }

    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }
}
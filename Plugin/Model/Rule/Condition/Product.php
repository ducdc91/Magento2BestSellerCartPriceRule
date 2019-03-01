<?php

namespace Shopstack\BestSellerCartRule\Plugin\Model\Rule\Condition;

class Product
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var \Shopstack\BestSellerCartRule\Helper\Data
     */
    protected $helperData;

    /**
     * Product constructor.
     *
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Shopstack\BestSellerCartRule\Helper\Data $helperData
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Shopstack\BestSellerCartRule\Helper\Data $helperData
    ) {
        $this->productRepository = $productRepository;
        $this->helperData = $helperData;
    }

    /**
     * Add best seller in condition backend
     *
     * @param \Magento\SalesRule\Model\Rule\Condition\Product $subject
     * @param $result
     * @return mixed
     */
    public function afterLoadAttributeOptions(
        \Magento\SalesRule\Model\Rule\Condition\Product $subject,
        $result
    ) {
        $attributes = $subject->getAttributeOption();

        $attributes['bestseller_top'] = __('Best Seller Top');

        asort($attributes);
        $subject->setAttributeOption($attributes);

        return $result;
    }

    /**
     * Add best seller position in product and validate
     *
     * @param \Magento\SalesRule\Model\Rule\Condition\Product $subject
     * @param callable $proceed
     * @param \Magento\Framework\Model\AbstractModel $model
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function aroundValidate(
        \Magento\SalesRule\Model\Rule\Condition\Product $subject,
        callable $proceed,
        \Magento\Framework\Model\AbstractModel $model
    ) {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $model->getProduct();
        if (!$product instanceof \Magento\Catalog\Model\Product) {
            $product = $this->productRepository->getById($model->getProductId());
        }
        $position = $this->helperData->getPositionInBestSeller($product->getId());

        $product->setBestsellerTop($position);

        $result = $proceed($model);

        return $result;
    }
}
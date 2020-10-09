<?php declare(strict_types=1);


namespace MoteqProductInquiry\Core\Content\ProductInquiry;


use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class ProductInquiryCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return ProductInquiryEntity::class;
    }
}

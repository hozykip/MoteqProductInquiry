<?php

namespace MoteqProductInquiry\Core\Content\Product;

use MoteqProductInquiry\Core\Content\ProductInquiry\ProductInquiryDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductExtension extends EntityExtension
{

    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }

    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new OneToManyAssociationField(
                'productInquiries',
                ProductInquiryDefinition::class,
                'product_id'
            ))
        );
    }
}

<?php

class WebninjaCatalogInventory_Model_Product_Api_V2 extends Mage_Catalog_Model_Product_Api_V2
{
    /**
     *  Set additional data before product saved
     *
     *  @param    Mage_Catalog_Model_Product $product
     *  @param    array $productData
     *  @return   object
     */
    protected function _prepareDataForSave($product, $productData)
    {
        parent::_prepareDataForSave($product, $productData);

        if (property_exists($productData, 'group_price')) {
            $groupPrices = Mage::getModel('webninjacataloginventory/product_attribute_groupprice_api_V2')
            ->prepareGroupPrices($product, $productData->group_price);
            $product->setData('group_price', $groupPrices);
        }
    }
}
